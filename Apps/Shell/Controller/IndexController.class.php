<?php
namespace Shell\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function test() {
        echo 'test';
    }

    public function getDB () {
        $lagou = D('Worklist');
        $lw_fields = array('key_word' , 'location' , 'total_page' ,'page');
        $li_fields = array('city' , 'companyLabel' , 'companyLogo' , 'companyName' , 'companyShortName' , 'companySize' , 'createTime' , 'createTimeSort' , 'education' , 'financeStage' , 'formatCreateTime' , 'hrScore' , 'industryField' , 'jobNature' , 'leaderName' , 'positionAdvantage' , 'positionFirstType' , 'positionName' , 'positionType' , 'salary' , 'workYear' ,'batchid');
        $city = '';
        $desc = '';
        $post_data = array( 'first'=> true , 'kd' => '' , 'pn' => 1);
        $url = 'http://www.lagou.com/jobs/positionAjax.json?px=default';
        if( !empty( $city ) ) $url .= '&city=' . htmlentities( $city );
        $batch = time();
        for( $i = 2 ; $i <= 10000 ;$i ++ ) {
            $post_data['first'] = false;
            $post_data['pn'] = $i;
            $output = $lagou->get_url( $url , $post_data );
            $lagou->insert_work( $output['content']['result'] , $li_fields , $batch);
        }
    }
}