<?php /** libraries/dovecote.php **/ 

class dovecote {

	protected $ci, $timeline;

	public function __construct() {
		$this->ci = &get_instance();		
	}

	// grab a mixed feed
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