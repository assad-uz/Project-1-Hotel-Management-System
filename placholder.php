<?php

   if(isset($_GET["page"])){
	   $page=$_GET["page"];
	   
	   if($page==0){
		   
		 include("pages/admin/admin-dashboard.php"); 
		   
	   }elseif($page==1){
		   
		 include("pages/admin/user/add_user.php"); 
		   
	   }else if($page==2){
		   
		   include("pages/admin/user/manage_user.php");
		  
	   }else if($page==3){
		   include("pages/admin/user/edit_user.php");
		  
	   }else if($page==4){
		   
		   include("pages/admin/room-service/add_roomservice.php");
		  
	   }else if($page==5){
		   
		   include("pages/admin/room-service/manage_roomservice.php");
		  
	   }else if($page==6){
		   
		   include("pages/admin/room-service/edit_roomservice.php");
		  
	   }else if($page==7){
		   
		   include("pages/admin/food-service/add_foodservice.php");
		  
	   }else if($page==8){
		   
		   include("pages/admin/food-service/manage_foodservice.php");
		  
	   }else if($page==9){
		   
		   include("pages/admin/food-service/edit_foodservice.php");
		  
	   }else if($page==10){
		   
		    include("pages/admin/room-type/add_roomtype.php");
		  
	   }else if($page==11){
		   
		    include("pages/admin/room-type/manage_roomtype.php");
		  
	   }else if($page==12){
		   
		    include("pages/admin/room-type/edit_roomtype.php");
		  
	   }else if($page==13){
		   
		    include("pages/admin/booking/add_booking.php");
		  
	   }else if($page==14){
		   
		    include("pages/admin/booking/manage_booking.php");
		  
	   }else if($page==15){
		   
		    include("pages/admin/booking/edit_booking.php");
		  
	   }else if($page==16){
		    include("");
   		}else{
	   		echo "Welcome to my New Project";
   		}
    }

?>