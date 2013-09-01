## Introduction

This tutorial will create a spark--dovecote--that combines an RSS feed and a user's recent tweets into a single unified timeline.

Think of a spark as a recycleable module that can make development a whole lot easier. Maybe you need an interface to an S3 storage buckets with Amazon? There's [a spark](http://getsparks.org/packages/amazon-s3/versions/HEAD/show) for that.

Let's get started.

## Setting up

The sparks system has been confirmed for integration into Codeigniter's core--possibly with the upcoming 2.1 release--but they aren't yet included in the default installation. If you aren't already using them, you'll need to set them up yourselves. 

If you're on OSX or Linux, or if you have PHP's command-line interface installed on Windows, installation is as simple as issuing the following from the root directory of a clean Codeigniter installation:

	$ cd php -r "$(curl -fsSL http://getsparks.org/go-sparks)"

If for some reason that didn't work, or if you're on Windows without PHP in your command path, you can also install sparks manually. It's a little more work, but the destination is the same:

1. Adding a directory named `sparks` in the root of your codeigniter directory
2. Adding a custom [Loader Class](http://getsparks.org/static/install/MY_Loader.php.txt) to application/core/MY_Loader.php
3. (optional) Downloading and extracting the [sparks command line utility](http://getsparks.org/download) into your codeigniter directory

Your Codeigniter installation should now be patched to support sparks. And it's time to write one of our own.

## Building a new spark



### Choosing a name

In medieval Europe, every manor house included a small outbuilding for pigeons to nest called a Dovecote. Since we'll be building a spark that involves both tweeting and feed, the name is appropriate enough. But it also meets the only requirement on naming: to be included in the repository at GetSparks.org,

> GetSparks project names must be unique

Before we can code, we'll need to layout a project. In the `sparks` directory in the root of your Codeigniter installation, create a new folder to hold the spark:

	/sparks/dovecote

Convention dictates that sparks are organized by version, so we'll need a subfolder to hold the first draft. `0.0.1` is a good place to start. 

	/sparks/dovecote/0.0.1

This folder is where all the action will take place. When the rest of the tutorial refers to our "spark directory", this is it. 

###The spark.info file

Inside the spark directory, create a `spark.info` file and add the following:

	name: dovecote
	version: 0.0.1
	compatibility: 2.0.2
	dependencies: 
	   Atomizer: 0.0.1
	tags: ["twitter","api","social"]

`spark.info` files provide the spark manager utility with the information it needs to manage the version and dependencies of all the sparks installed on the system. For now, its contents are limited to five fields:

<!--@yaml:
template: table
content:
   - [tag           , description]
   - [name          , the unique spark id]
   - [version       , current version]
   - [compatibility , minimum Codeigniter version]
   - [dependencies  , sparks this spark depends on]
   - [tags          , tags that describe this spark's function]
-->

Even if you aren't planning to use the spark manager yourself, it's polite to include a `spark.info` file with any spark you distribute so that others can. One of the real advantages to managing sparks this way, rather than pasting them directly into the `sparks` directory, is that the spark manager can use the compatibility, dependency, and version information in each spark to ensure that they will play nicely with the current Codeigniter installation--and each other. As we will see in a moment, sparks installed without the benefit of the manager utility must have their dependencies manually provided.

###Organizing the spark

With the info file written, it's time to give the spark some structure. Create four new folders in the spark directory:

* config
* helpers
* libraries
* views

If you've worked with Codeigniter before, these are probably familiar names. Codeigniter's `loader` class treats sparks as packages, meaning that the contents of these directories are checked for any application components that can't be found in the `/application` directory. For now, this works on resource types:

* configs
* helpers
* libraries
* models
* views

##Writing the Spark

Before we begin coding, take a moment to ensure that your spark directory contains all the necessary pieces.

~FIGURE 1~

Everything in order? Let's proceed.

Create a file in the newly-created `config` directory and name it `dovecote.php`. We'll store a few basic options here to tell the spark where it can find RSS data:

	<?php /** config/dovecote.php **/
	
	// Username to retrieve tweets from:
	$config[ 'twitter' ]    = 'getsparks';

	// API endpoint to query for tweets:
	$config[ 'twitterURL' ] = 'http://twitter.com/statuses/user_timeline/%s.rss';
	
	// Feed carrying RSS data:
	$config[ 'feedURL' ]    = 'http://codeigniter.com/feeds/rss/full/';

	?>

Now the spark knows where data can be found, it's time to go retrieve some feeds. To do this, we'll need to create a library--call it `dovecote.php`--and save it in the `libraries` directory:

	<?php /** libraries/dovecote.php **/ 
	
	class dovecote {
	
		protected $ci, $timeline;
	
		public function __construct() {
			$this->ci = &get_instance();		
		}

		public function retrieve() {

			// build twitter request URL
			$twitterURL = sprintf( $this->option( 'twitterURL' ), $this->option( 'twitter' ) );
	
			// get RSS Data
			$tweets = $this->ci->atomizer->loadURL( $twitterURL );
			$feed = $this->ci->atomizer->loadURL( $this->option( 'feedURL' ) );
	
			// set channel information for new feed
			$info = array(
				'title' => 'Convolved feed'
			);
	
			// mix the two feeds together
			$this->timeline = $feed->convolve( $tweets, $info );
	
			return $this->timeline;
		}
		
		public function publish() {
			header('content-type: application/rss+xml');
			echo $this->timeline->save();
		}
	
		// retrieve an option ($key) from config files
		protected function option( $key ) {
			return $this->ci->config->item( $key );
		}
	}
	
	?>

This library provides helper functions to retrieve options from our config file and publish an RSS feed, but the critical piece is `retrieve()`. This function grabs RSS data from the providers described in dovecote's configuration file in several steps:

* First, the address of the Twitter RSS feed is generated. Config outlined a username (`twitter`) and an endpoint (`twitterURL`); now, the two are combined using `sprintf`.
* Next, the RSS data in each feed are retrieved using the `loadURL` function the `atomizer` library. This function returns an "`AtomizerFeed`" object that provides some useful functions for manipulating RSS data.
* Finally, `AtomizerFeed`'s `convolve` operation is used to combine the two feeds' items into a single feed, which is returned.

##Loading the Spark

At this point, we're almost ready to fire up dovecote in a live application. We just need to check to make sure that our application includes all of dovecote's dependencies and that the spark itself will load correctly. 

###Gathering dependencies

When we wrote `spark.info`, recall the line that described dovecote's dependencies:

	Dependencies:
	   Atomizer: 0.0.1

This means that dovecote relies on another spark--Atomizer--to function. Once sparks are committed to the [getsparks.org](http://getsparks.org) repository, the manager utility will download dependencies automatically. While we remain in local development, however, we'll need to do this ourselves.

If you're using the sparks manager, you can install Atomizer by navigating to your Codeigniter directory and invoking the manager's `install` function:

	php tools/spark install atomizer
	
Note: if you're on windows, you will need to invoke `php tools\spark install atomizer` instead.

If you aren't using the manager, [download Atomizer](https://github.com/rjz/Spark-Atomizer) and extract it into `codeigniter/sparks` next to the folder for dovecote.

###Autoloading components

To access dovecote in other parts of the application, we'll first need to make sure that it will load correctly. Return to the config folder in your spark directory and create a new file called `autoload.php`.

	<?php /** config/autoload.php **/

	// load default configuration
	$autoload['config'] = array( 'dovecote' );
	
	// load dependency
	$autoload['sparks'] = array( 'atomizer/0.0.2' );
	
	// load library
	$autoload['libraries'] = array( 'dovecote' );
	?>

Whenever Codeigniter loads a spark, it will attempt to load all the resources listed in `autoload.php` as well. This allows the spark to ensure that everything it needs to function will be bundled in as it loads. Because the `dovecote` library is specified here, for instance, we will have immediate access to the `retrieve` function any time we load the spark. 

It's worth mentioning that the resources described in `autoload.php` need not reside in the spark directory. As long as they're located somewhere in Codeigniter's search path, the application should be able to find them.

Save the autoload file and give it a try. In the welcome controller of your main application (`/application/controllers/welcome.php`), add the following:

	function dovecote() {
		$this->load->spark( 'dovecote/0.0.1' );
		$this->dovecote->retrieve();
		$this->dovecote->publish();
	}

Browse to `welcome/dovecote` in your browser, and you should be greeted with an RSS feed chronicling the tweets and articles that dovecote has collected.

##Building on the spark

Let's make Dovecote a little more useful. First, we'll create a really simple view template that will show the title of each article in our timeline:

	<?php /** views/dovecote_timeline.php */ ?>
	
	<h3>Recent Happenings:</h3>
	<ol>
	<?php foreach ($items as $item): ?>
		<li><?php echo $item->title; ?></li>
	<?php endforeach; ?>
	</ol>

Next, we'll make the view accessible by providing a helper function that other parts of the application can use to include the timeline's HTML. 

	<?php /** helpers/dovecote_helper.php */
	
	function dovecote_timeline() {
	
		$ci = &get_instance();
	
		$feed = $ci->dovecote->retrieve();
		
		$data = array(
			'items' => $feed->items()
		);
	
		$ci->load->view( 'dovecote_timeline', $data );
	}
	
	?>

We can now use the `dovecote_timeline` function and its eponymous view to render the timeline as a list of titles anywhere in our application. Because this functionality isn't required for dovecote's basic functions, we won't include it in our autoload file. Instead, we'll call on it manually whenever it is needed. Return to your application's welcome controller, and update your `dovecote` function to generate an HTML feed:

	function dovecote() {
		$this->load->spark( 'dovecote/0.0.1' );
		$this->load->helper( 'dovecote' );
		$this->dovecote->retrieve();
		
		echo dovecote_timeline();
	}

Refresh your browser, and you should now see the titles of each item in dovecote's timeline.

##Closing

Congratulations! You're now the owner of a very simple spark. 

Some additions may include:

* **caching** of API responses
* **views** that beautify the data retrieved
* **persistence** of data using a model and database