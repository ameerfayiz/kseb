<?php 		
        
        $token	= urldecode($_GET['token']);
		$bvolt   = urldecode($_GET['bvolt']);
		$cvolt   = urldecode($_GET['cvolt']);
		$pvolt   = urldecode($_GET['pvolt']);
		$svolt   = urldecode($_GET['svolt']);
		$interrupt   = urldecode($_GET['interrupt']);
		$flevel   = urldecode($_GET['flevel']);
   
		if($token=="s8asd5a4f68wefa651f9e4fa16c5a19f4a"){			
			$con=mysqli_connect("localhost","root","emobitkallan","e_vending");
			// Check connection
			if(mysqli_connect_errno())
			  {
			  echo "Failed to connect to MySQL: " . mysqli_connect_error();
			  }
			$sql="SELECT * FROM product WHERE checksum='$code'";	
			$result=mysqli_query($con,$sql);
			if (mysqli_num_rows($result)>0)
			  {		  
		        date_default_timezone_set("Asia/Calcutta");
				print "YOU CAN PROCEED, HAPPY SHOPPING " .  time() . " " .  date_default_timezone_get() . " " . date("[Y/m/d_h:i:sa]",time());
			  }
			else
			{
				print "invalid promo";
			}	
			mysqli_close($con);
		}else{
			print "invalid promo";
		}
 
?>

