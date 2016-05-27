<?php
namespace MetzWeb\Instagram;

class Endpoints 
{
    public $result;
    
	public function set_result($result){
        $this->result = $result;
    }
	public function display_searchLocation_results()
    {
        // display all user likes
        foreach ($this->result->data as $location) {
           $this->display_location($location);
        }
	}
    public function display_getLocation_results()
    {
        $this->display_location($this->result->data);
    }
    
    private function display_location($location)
    {
        $content = '<li>';  
        $content .= "<div class=\"content\">
               <div class=\"location_id\" >
                <p>{$location->latitude}</p>
                <p>{$location->longitude}</p>
                <p>{$location->name}</p>
               </div>
               </div>";
        echo $content . '</li>';
    }
}
?>