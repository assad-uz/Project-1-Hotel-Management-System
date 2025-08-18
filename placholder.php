<?php
//    if(isset($_GET['user'])){
// 	$user = $_GET['user'];
// 	if ($user == 1) {
// 		include "welcome.php";
// 	}elseif($user == 2){
// 		include "welcome.php";
// 	}elseif($user == 3){
// 		header("location:logout.php");
// 	}
// }


   if(isset($_GET["page"])){
	   $page=$_GET["page"];
	   
	   if($page==0){
		   
		 include("pages/dashboard.php"); 
		   
	   }elseif($page==1){
		   
		 include("pages/user/add_user.php"); 
		   
	   }else if($page==2){
		   
		   include("pages/user/manage_user.php");
		  
	   }else if($page==3){
		   include("pages/user/edit_user.php");
		  
	   }else if($page==4){
		   
		   include("pages/meal/mealtype/add_meal.php");
		  
	   }else if($page==5){
		   
		   include("pages/meal/mealtype/manage_meal.php");
		  
	   }else if($page==6){
		   
		   include("pages/user/view_user.php");
		  
	   }else if($page==7){
		   
		    include("pages/category/add_cat.php");
		  
	   }else if($page==8){
		   
		    include("");
		  
	   }
	   
   }else{
	   
       echo "Welcome to my New Project";
   }

?>