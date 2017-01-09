<?php
class mod_news extends CI_Model {
	
	function __construct(){
		
        parent::__construct();
    }
	public function get_all_news(){

		$get_news = $this->db->get('kt_news');

		$row_news['news_arr'] = $get_news->result_array();
		$row_news['news_count'] = $get_news->num_rows;
		return $row_news;
		
	}
	public function get_news($news_id){
		
		$this->db->where('id',$news_id);
		$get_news = $this->db->get('kt_news');
		$row_news['news_arr'] = $get_news->row_array();
		$row_news['news_count'] = $get_news->num_rows;
		return $row_news;
		
	}
	public function news_slug_generator($slug) {
        $newslug = str_replace(" ","-",strtolower($slug));
        $i = 0;
        $slug2 = $newslug;
        while ($i >= 0) {
            $this->db->where("slug_news", $slug2);
            $count = $this->db->count_all_results('kt_news');
            if ($count < 1) {
                if ($i == 0) {
                    return $slug2;
                    break;
                } else {
                    return $slug2;
                    break;
                }
            }
            $slug2 .= "-" . ($i + 1);
            $i++;
        }

    }
	

	public function delete_news($news_id){


		$get_news_data = $this->mod_news->get_news($news_id);
		$get_news_data_arr = $get_news_data['news_arr'];
		$this->db->where('id',$news_id);
		$del_into_db = $this->db->delete('kt_news');
		//echo $this->db->last_query(); exit;
		
		if($del_into_db) return true;

	}//end delete_sponsor()


}
?>