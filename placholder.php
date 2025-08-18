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
		   
		   include("pages/meal/mealtype/edit_meal.php");
		  
	   }else if($page==7){
		   
		    include("pages/meal/mealperiod/add_meal_period.php");
		  
	   }else if($page==8){
		   
		    include("pages/meal/mealperiod/manage_meal_period.php");
		  
	   }else if($page==9){
		   
		    include("pages/meal/mealperiod/edit_meal_period.php");
		  
	   }else if($page==10){
		   
		    include("pages/services/foodservice");
		  
	   }else if($page==11){
		   
		    include("pages/services/foodservice");
		  
	   }else if($page==12){
		   
		    include("pages/services/foodservice");
		  
	   }else if($page==13){
		   
		    include("pages/services/roomservice");
		  
	   }else if($page==14){
		   
		    include("pages/services/roomservice");
		  
	   }else if($page==15){
		   
		    include("pages/services/roomservice");
		  
	   }else if($page==16){
		   
		    include("pages/services/roomservice");
		  
	   }else if($page==17){
		   
		    include("pages/services/roomservice");
		  
	   }else if($page==18){
		   
		    include("pages/services/roomservice");
		  
	   }else if($page==19){
		   
		    include("pages/services/roomservice");
		  
	   }else if($page==20){
		   
		    include("pages/services/roomservice");
		  
	   }else if($page==21){
		   
		    include("pages/services/roomservice");
		  
	   }else if($page==22){
		   
		    include("pages/services/roomservice");
		  
	   }else if($page==23){
		   
		    include("pages/services/roomservice");
		  
	   }
	   
   }else{
	   
       echo "Welcome to my New Project";
   }

?>