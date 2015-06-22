<?php 




/*list category 

Marketing----------
Accounting-------------
Engineering---------
Finance-----------
Law------------
Biology
Computer Science---
Art & Design-----
Business ------------

*/


/* category !!!! http://www.internships.com/computer-science?page=2*/

/*key word research http://www.internships.com/search/posts?Keywords=engineer%20&Location=newtork&page=2 */



ini_set('display_errors',1); 
error_reporting(E_ALL);

$fp = fopen('computer.csv', 'w');

include('inc/simple_html_dom.php');

for($p = 1; $p < 500 ; $p++) {



$html = file_get_html('http://www.internships.com/computer-science?page='.$p); /*http://www.internships.com/computer-science?page=2  */

// Find all posts
foreach($html->find('div.internship-result-link-item') as $post) {
// initialisation 
	$item['internship-payment'] = 'Not paid ';
    $item['College-Credit-Required'] = 'false' ; 

    $item['description'] = $post->find('div.description', 0)->plaintext ; 
    $item['company-name'] = $post->find('span.company-name', 0)->plaintext ; 
    $item['company-name'] = $post->find('span.internship-location', 0)->plaintext ; 
    $item['internship-dates'] = $post->find('div.internship-dates', 0)->plaintext ; 
    $item['internship-link'] = $post->find('a', 0)->href ;
    $item['internship-title'] = $post->find('a', 0)->title; 


   foreach($post->find('img.tip') as $info) {

 	$tmp = $info->title;

 	switch($tmp)
{ 
  
    case 'Part Time':
    $item['internship-working-time'] = 'Part Time' ;
    break;

    case 'Paid Opportunity':
    $item['internship-payment'] = 'Paid Opportunity' ;
    break;

    case 'Full Time':
    $item['internship-working-time']  = 'Full Time' ;
    break;

    case 'College Credit Required':
    $item['College-Credit-Required']  = 'true' ;
    break;

    default :
        echo 'not known !!!!!!!!!!!!!!!!!!!';
    break;
}



    }
 echo  $item['internship-title'] ;    

 fputcsv($fp,$item);

/*----------------------INSERT contry if not exist , get country ID , INSERT Job using country id  ---------------------------------------------

INSERT INTO `cities` (`id`, `name`, `ascii_name`) VALUES
(1, 'London', 'LN')


 INSERT INTO `jobs` (`id`, `type_id`, `category_id`, `title`, `description`, `company`, `city_id`, `url`, `apply`, `created_on`, `is_temp`, `is_active`, `views_count`, `auth`, `outside_location`, `poster_email`, `apply_online`, `spotlight`) VALUES
(1, 1, 1, 'web developer', 'We\\''re a startup searching for a cool web developer that masters following technologies:\r\n* php, mysql\r\n* javascript, dom, ajax\r\n* html, css\r\n\r\nPerson should also have a good sense of user behavior.\r\n\r\nExcellent payment! ;)', 'Foo Inc.', NULL, 'http://www.fooinc.com', '', '2008-08-20 09:35:29', 0, 1, 10, 'f1acd80152446f4cf8a0bb8242398be7', 'sss', 'jobs@fooinc.com', 1, 1) ;    

*/





} // foreach post found 



} // for page

fclose($fp);  

?>