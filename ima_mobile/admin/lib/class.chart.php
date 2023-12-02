<?php
class chart {
	function __construct(){
		$this->db	     = new mysql();
	}
	/**
	* Function to get client tickets list
	*/
	function getChartList(){
		$this->db->open();
                $query_pag_data   = "SELECT * FROM chart_week order by chart_week_id desc";            
		$chartList = $this->db->fetchArray($this->db->query($query_pag_data));
		$this->db->close();
		return $chartList;
	}
        
        function addChart($insertArr){
               $this->db->open();
                $results = $this->db->insertRecord('chart_week', $insertArr);
                return $results;
                $this->db->close();
          }
        
        
        function getChartDetails($chartId){
            
                $this->db->open();		
                $query_pag_data   = "SELECT * FROM chart_week WHERE chart_week_id='$chartId'";            
		$postDetails = $this->db->fetchArray($this->db->query($query_pag_data));
		$this->db->close();
		return $postDetails;
            
        }
        
         function updateChartTxt($txt,$title,$editId){
            $this->db->open();
            $query_pag_data   = "update chart_week set  chart_week_text = '$txt',chart_week_title = '$title' where chart_week_id = '$editId'";
            $results = $this->db->query($query_pag_data );
	    $this->db->close();
            return $results;
        }
        
        function updateChartImgs($chartId,$image){
            $this->db->open();
            $query_pag_data   = "update chart_week set chart_week_img  = '$image' where chart_week_id = '$chartId'";
            $results = $this->db->query($query_pag_data );
	    $this->db->close();
            return $results;
        }
        
        function updateBigChartImgs($chartId,$image){
            $this->db->open();
            $query_pag_data   = "update chart_week set chart_week_img_big  = '$image' where chart_week_id = '$chartId'";
            $results = $this->db->query($query_pag_data );
	    $this->db->close();
            return $results;
        }
          //####################GRAPH#######################################
		 function addGraph($insertArr){ 

               $this->db->open();

                $results = $this->db->insertRecord('graph_details', $insertArr);

                return $results;

                $this->db->close();

          }
		  
		  function addMapGraph($insertArr){ 

               $this->db->open();

                $results = $this->db->insertRecord('mapgraph_details', $insertArr);

                return $results;

                $this->db->close();

          }
		  
		  function getGraphList($cond=''){ 

		$this->db->open();

        $query_pag_data   = "SELECT * FROM graph_details"; 

		if($cond!='')

		{

		 $query_pag_data  .= " where $cond"; 

		} else {  $query_pag_data  .= " order by gid desc"; }          

		$chartList = $this->db->fetchArray($this->db->query($query_pag_data));

		$this->db->close();

		return $chartList;

	}
	
	
	
	 
	
	
	function getMapList($cond=''){ 

		$this->db->open();

        $query_pag_data   = "SELECT * FROM mapgraph_details"; 

		if($cond!='')

		{

		 $query_pag_data  .= " where $cond"; 

		} else {  $query_pag_data  .= " order by gid desc"; }          

		$chartList = $this->db->fetchArray($this->db->query($query_pag_data));

		$this->db->close();

		return $chartList;

	}

	 function updateGraphdetails($id,$source,$title,$txt,$is_premium,$xfile,$updated_page){

            $this->db->open();

            $query_pag_data   = "update graph_details set  source = '$source', title = '$title', description ='$txt',isPremium = '$is_premium', filepath ='$xfile',updated_page ='$updated_page' where gid = '$id'";

            $results = $this->db->query($query_pag_data );

	    $this->db->close();

            return $results;

        }
		
		
		function updateMapdetails($id,$source,$title,$txt,$is_premium,$xfile){

            $this->db->open();

            $query_pag_data   = "update mapgraph_details set  source = '$source', title = '$title', description ='$txt',isPremium = '$is_premium', filepath ='$xfile' where gid = '$id'";

            $results = $this->db->query($query_pag_data );

	    $this->db->close();

            return $results;

        }

	function deleteGraphdetails($id){

            $this->db->open();

            $query_pag_data   = "delete from graph_details where gid = '$id'";

            $results = $this->db->query($query_pag_data );

	    $this->db->close();

            return $results;

        }
		
		function deleteMapdetails($id){

            $this->db->open();

            $query_pag_data   = "delete from mapgraph_details where gid = '$id'";

            $results = $this->db->query($query_pag_data );

	    $this->db->close();

            return $results;

        }

	 function addValues($insertArr){ 

	   $this->db->open();

		$results = $this->db->insertRecord('graph_values', $insertArr);

		return $results;

		$this->db->close();

     }
	 
	   function addMapValues($insertArr){ 

	   $this->db->open();

		$results = $this->db->insertRecord('map_values', $insertArr);

		return $results;

		$this->db->close();

		  }

		  

	function deletegraph_values($id){

            $this->db->open();

            $query_pag_data   = "delete from graph_values where gid = '$id'";

            $results = $this->db->query($query_pag_data );

	    $this->db->close();

            return $results;

        }
		
		
	
		
		
	function deletemap_values($id){

            $this->db->open();

            $query_pag_data   = "delete from map_values where gid = '$id'";

            $results = $this->db->query($query_pag_data );

	    $this->db->close();

            return $results;

        }	
		
        
    function getHomepageGraph(){
    	$this->db->open();
        $query_pag_data   = "SELECT * FROM homepage_graph order by id desc LIMIT 1";            
		$results = $this->db->fetchArray($this->db->query($query_pag_data));
		$this->db->close();
		return $results;
    	
    }
   
   function saveHomapageGraph($vals) {
	    $this->db->open();
	    $query_pag_data   = "update homepage_graph set  title = '".addslashes($vals['title'])."', description = '".addslashes($vals['description'])."', graph_code ='".$vals['graph_code']."', report_link ='".$vals['report_link']."', published_date ='".$vals['published_date']."' where id = '".$vals['homepage_graph_id']."'";
	    $results = $this->db->query($query_pag_data );
	  //  exit($query_pag_data);
	    $this->db->close();
	    return $results;
   }
		//#################################################################
        
}
?>
