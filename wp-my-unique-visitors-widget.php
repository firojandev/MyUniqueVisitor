<?php

/*
  Plugin Name: Unique Visitors Counters
  Plugin URI: http://digi-techbd.com/unique-visitors-counters
  Description: This job is to count the Unique visitors
  Author: Altaf Hoshain
  Version: 1.0.0
  Author URI: http://digi-techbd.com/
  
 */

  function unique_visitors_counter() {

  	$options = get_cuv_options();

  	if ($_POST['wp_cuv_Submit']) {
        $options['wp_cuv_WidgetTitle'] = htmlspecialchars($_POST['wp_cuv_WidgetTitle']);
        $options['wp_cuv_WidgetText_Visitors'] = htmlspecialchars($_POST['wp_cuv_WidgetText_Visitors']);
        $options['wp_cuv_WidgetText_Today'] = htmlspecialchars($_POST['wp_cuv_WidgetText_Today']);
        $options['wp_cuv_WidgetText_ThisWeek'] = htmlspecialchars($_POST['wp_cuv_WidgetText_ThisWeek']);
        $options['wp_cuv_WidgetText_ThisMonth'] = htmlspecialchars($_POST['wp_cuv_WidgetText_ThisMonth']);
        $options['wp_cuv_WidgetText_ThisYear'] = htmlspecialchars($_POST['wp_cuv_WidgetText_ThisYear']);
        $options['wp_cuv_WidgetText_TopVisitorsCountry'] = htmlspecialchars($_POST['wp_cuv_WidgetText_TopVisitorsCountry']);
                
        update_option("widget_unique_visitors_counter", $options);
    }

    ?>

    <p><strong>Use options below to translate English labels</strong></p>
    <p>
        <label for="wp_cuv_WidgetTitle">Text Title: </label>
        <input type="text" id="wp_cuv_WidgetTitle" name="wp_cuv_WidgetTitle" value="<?php echo ($options['wp_cuv_WidgetTitle'] == "" ? "Unique Visitors Counter" : $options['wp_cuv_WidgetTitle']); ?>" />
    </p>

     <p>
        <label for="wp_cuv_WidgetText_Visitors">Text Views: </label>
        <input type="text" id="wp_cuv_WidgetText_Visitors" name="wp_cuv_WidgetText_Visitors" value="<?php echo ($options['wp_cuv_WidgetText_Visitors'] == "" ? "Visitors" : $options['wp_cuv_WidgetText_Visitors']); ?>" />
    </p>

    <p>
        <label for="wp_cuv_WidgetText_Today">Text Todays: </label>:
        <input type="text" id="wp_cuv_WidgetText_Today" name="wp_cuv_WidgetText_Today" value="<?php echo ($options['wp_cuv_WidgetText_Today'] == "" ? "Todays" : $options['wp_cuv_WidgetText_Today']); ?>" />
    </p>


     <p>
        <label for="wp_cuv_WidgetText_ThisWeek">Text This Weeks: </label>:
        <input type="text" id="wp_cuv_WidgetText_ThisWeek" name="wp_cuv_WidgetText_ThisWeek" value="<?php echo ($options['wp_cuv_WidgetText_ThisWeek'] == "" ? "This Week" : $options['wp_cuv_WidgetText_ThisWeek']); ?>" />
    </p>


     <p>
        <label for="wp_cuv_WidgetText_ThisMonth">Text This Months: </label>:
        <input type="text" id="wp_cuv_WidgetText_ThisMonth" name="wp_cuv_WidgetText_ThisMonth" value="<?php echo ($options['wp_cuv_WidgetText_ThisMonth'] == "" ? "This Month" : $options['wp_cuv_WidgetText_ThisMonth']); ?>" />
    </p>

    <p>
        <label for="wp_cuv_WidgetText_ThisYear">Text This Year: </label>:
        <input type="text" id="wp_cuv_WidgetText_ThisYear" name="wp_cuv_WidgetText_ThisYear" value="<?php echo ($options['wp_cuv_WidgetText_ThisYear'] == "" ? "This Year" : $options['wp_cuv_WidgetText_ThisYear']); ?>" />
    </p>

    <p>
        <label for="wp_cuv_WidgetText_TopVisitorsCountry">Text Top Visitors Country: </label>:
        <input type="text" id="wp_cuv_WidgetText_TopVisitorsCountry" name="wp_cuv_WidgetText_TopVisitorsCountry" value="<?php echo ($options['wp_cuv_WidgetText_TopVisitorsCountry'] == "" ? "Top Visitors Country" : $options['wp_cuv_WidgetText_TopVisitorsCountry']); ?>" />
    </p>


     <p>
        <input type="hidden" id="wp_cuv_Submit" name="wp_cuv_Submit" value="1" />
    </p>


   <?php


  }


  function get_cuv_options() {

    $options = get_option("widget_unique_visitors_counter");

    if (!is_array($options)) {
        $options = array(
            'wp_cuv_WidgetTitle' => 'Unique Visitors Counter',
            'wp_cuv_WidgetText_Visitors' => 'Visitors',
            'wp_cuv_WidgetText_Today' => 'Todays',
            'wp_cuv_WidgetText_ThisWeek' => 'This Week',
            'wp_cuv_WidgetText_ThisMonth' => 'This Month',
            'wp_cuv_WidgetText_ThisYear' => 'This Year',
            'wp_cuv_WidgetText_TopVisitorsCountry' => 'Top Visitors Country'
                        
        );
    }
    return $options;
}

function widget_unique_visitors_counter($args) {
    extract($args);
    $options = get_cuv_options();

    echo $before_widget;
    echo $before_title . $options["wp_cuv_WidgetTitle"];
    echo $after_title;
    view();
    echo $after_widget;
}

function view() {
    global $wpdb;
    $options = get_cuv_options();
    $table_name = $wpdb->prefix . "mycuv_log";

       $dt = new DateTime();
       $date = $dt->format('Y-m-d');

      $todaysVisitor = $wpdb->get_var("SELECT COUNT(*) FROM $table_name  WHERE dates= '$date'");
      
      $staticStart = get_weekStartDate();
      $staticEnd = get_weekEndDate();
  
    //Calulate this week visitor    
    $weekVisitor = $wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE dates BETWEEN '$staticStart' AND '$staticEnd'");
   
     $monthStartDate = date('Y-m-01',strtotime('this month')) ;
     $monthEndDate = date('Y-m-t',strtotime('this month'));

     //Calulate this Month visitor    
     $monthVisitor = $wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE dates BETWEEN '$monthStartDate' AND '$monthEndDate'");
   

    $y = new DateTime();
    $year = $y->format('Y');
  
    $startDateOfYear = $year.'-01-01';
    $endDateOfYear = $year.'-12-31';

   //Calulate this Year visitor    
      $yearVisitor = $wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE dates BETWEEN '$startDateOfYear' AND '$endDateOfYear'");
   
    //get Visitor country list
     $visitorCountry = getTopVisitorCountry();

     ?>
      <ul>
        <li><?php echo $options["wp_cuv_WidgetText_Today"] . ": <span id='cuv_lds'>" . $todaysVisitor; ?></span></li>
        <li><?php echo $options["wp_cuv_WidgetText_ThisWeek"] . ": <span id='cuv_lws'>" . $weekVisitor; ?></span></li>
        <li><?php echo $options["wp_cuv_WidgetText_ThisMonth"]. ": <span id='cuv_lms'>" . $monthVisitor; ?></span></li>
        <li><?php echo $options["wp_cuv_WidgetText_ThisYear"]. ": <span id='cuv_lys'>" . $yearVisitor; ?></span></li>
        
    </ul>

      <h3><?php echo $options["wp_cuv_WidgetText_TopVisitorsCountry"]; ?></h3>

     <?php

       $i=0;    
       foreach ($visitorCountry as $key => $value) {
        if($i==5){
          break;
        }else{
          echo "$key($value)<br/>";
        }
        
        $i++;
      }

     
}

function geoCheckIP($ip)
{
    $response=@file_get_contents('http://www.netip.de/search?query='.$ip);

    $patterns=array();
    $patterns["country"] = '#Country: (.*?)&nbsp;#i';

    $ipInfo=array();

    foreach ($patterns as $key => $pattern)
    {
        $ipInfo[$key] = preg_match($pattern,$response,$value) && !empty($value[1]) ? $value[1] : 'Unknown';
    }

        return $ipInfo;
}

//Get weeken start date
function get_weekStartDate(){
   if(date('D')!='Sat')
         {    
        //take the last Saturday
         $sStart = date('Y-m-d',strtotime('last Saturday'));    

        }else{
         $sStart = date('Y-m-d');   
     }

     return $sStart;

}

//Get weenken end date
function get_weekEndDate(){
    if(date('D')!='Fri')
      {
        $sEnd = date('Y-m-d',strtotime('next Friday'));
     }else{

        $sEnd = date('Y-m-d');
     } 

     return $sEnd;
}

// Get user country by IP
function getTopVisitorCountry(){
     global $wpdb;
    $table_name = $wpdb->prefix . "mycuv_log";

    $retval = $wpdb->get_results("SELECT country FROM $table_name", ARRAY_A);

	  $arrVal = array();

    foreach($retval as $row)
    {
      $arrVal[] = $row['country']; 
    }

    $vals = array_count_values($arrVal);

    arsort($vals);
   

   return $vals;

}

  function unique_visitors_counter_init() {
    wp_cuv_install_db();
    UniqueVisitorCounterViews();
    register_sidebar_widget(__('Unique Visitors Counter'), 'widget_unique_visitors_counter');
    register_widget_control(__('Unique Visitors Counter'), 'unique_visitors_counter', 300, 200);
  }


  function add_cuv_stylesheet() {
    wp_register_style('cuvStyleSheets', plugins_url('cuv-styles.css', __FILE__));
    wp_enqueue_style('cuvStyleSheets');
  }

  function add_cuv_ajax() {
    wp_enqueue_script('cuvScripts', plugins_url('wp-cuv-ajax.js', __FILE__));
  }


  function uninstall_cuv() {

    global $wpdb;
    $table_name = $wpdb->prefix . "mycuv_log";
    delete_option("widget_unique_visitors_counter");
    delete_option("wp_cuv_WidgetTitle");
    delete_option("wp_cuv_WidgetText_Visitors");
    delete_option("wp_cuv_WidgetText_Today");
    delete_option("wp_cuv_WidgetText_ThisWeek");
    delete_option("wp_cuv_WidgetText_ThisMonth");
     delete_option("wp_cuv_WidgetText_ThisYear");
    delete_option("wp_cuv_WidgetText_TopVisitorsCountry");

    $wpdb->query("DROP TABLE IF EXISTS $table_name");
        
  }


  function wp_cuv_install_db() {

   global $wpdb;

    $table_name = $wpdb->prefix . "mycuv_log";
    $gTable = $wpdb->get_var("show tables like '$table_name'");
    
    if ($gTable != $table_name) {

        $sql = "CREATE TABLE " . $table_name . " (
           id INT( 11 ) NOT NULL AUTO_INCREMENT,
           ip VARCHAR( 17 ) NOT NULL ,
           dates date NOT NULL ,
           country VARCHAR(200) NOT NULL,
           PRIMARY KEY (id)
           );";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    } else {
       //do nothing
    }

  }
  
 
   function UniqueVisitorCounterViews() {
    global $wpdb;
    $options = get_cuv_options();
    $table_name = $wpdb->prefix . "mycuv_log";

    //get Visitor IP address
  if ($_SERVER['HTTP_X_FORWARD_FOR'])
          $ip = $_SERVER['HTTP_X_FORWARD_FOR'];
      else
          $ip = $_SERVER['REMOTE_ADDR'];

     $dt = new DateTime();
     $date = $dt->format('Y-m-d');

     $result = $wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE ip = '$ip' AND dates= '$date'");
   
    if($result>0){
      //already visited Today, don't need to insert
      }else{ 
         //Today fisrt visit,get the visitor country

     $co=geoCheckIP($ip);

     $cont=$co['country'];

     $p=explode( '-', $cont); //extract country code & Country name

     $cCode = $p[0]; //contain counrty code, not used here
    
     $uCountry = $p[1]; //contain country name
    
       if($uCountry==''){
         $uCountry = "Unknown";
         }else{
         $uCountry = $uCountry;
         }
            
       $data = array(
            'ip' => $ip,
            'dates' => $date,
            'country' => $uCountry
          );

        $format = array('%s', '%s', '%s', '%s');
        $wpdb->insert($table_name, $data, $format);

    }

  }

  add_action("plugins_loaded", "unique_visitors_counter_init");
  add_action('wp_print_styles', 'add_cuv_stylesheet');
  add_action('init', 'add_cuv_ajax');
  register_deactivation_hook(__FILE__, 'uninstall_cuv');

?>