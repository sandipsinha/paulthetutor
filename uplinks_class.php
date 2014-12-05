<? 

/**
	object 
	@url - String
	@postion - int
	@drop_position - int
	@label - String
	@link - String
**/
class Uplinks {

	public $folder = "";
	public $postion = 0;
	public $drop_position = 0;
	public $label = "";
	public $link = "";
	public $is_drop_down = false;
	public $drop_down_links = array();
	public $is_in_drop_down = false; 

	function __construct( $folder="", $postion=0, $drop_position=0, $label="", $link="", 
		$is_in_drop_down=false ) {
		
		$this->folder = $folder;
		$this->postion = $postion;
		$this->drop_position = $drop_position;
		$this->label = $label;
		$this->link = $link;
		$this->is_in_drop_down = $is_in_drop_down;

	}	

	public function addDropDownLink( $folder="", $label="", $link="" ) {
		if( !$this->is_drop_down ) $this->is_drop_down = true;

		$drop_down_position = sizeof( $this->drop_down_links ) + 1;
		$this->drop_down_links[] = new Uplinks( $folder, 
			$this->postion, 
			$drop_down_position, 
			$label,
			$link, 
			true );
	
	}

	public function getDropDownLink( $label="" ) {

		for( $n = 0; $n < sizeof( $this->drop_down_links ); $n++ ) {

			$link = $this->drop_down_links[ $n ];

			if( $link->label == $label ) return $link;

		}

		echo "WARNING: could not find drop down link with label $label.";

		return false;

	}

	public function updateDropDownLink( $link ) {

		for( $n = 0; $n < sizeof( $this->drop_down_links ); $n++ ) {

			$alink = $this->drop_down_links[ $n ];

			if( $alink->label == $link->label && $alink->link == $link->link && 
				$alink->postion == $link->postion && $alink->drop_position == $link->drop_position ) {

				$this->drop_down_links[ $n ] = $link;
				break;
			
			}

		}

	}

}

?>
