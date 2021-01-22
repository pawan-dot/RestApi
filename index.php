<?php
$con=mysqli_connect('localhost','root','','RestApi');
if($con==false)
{
    echo "connection is not done";
}
  
$request=$_SERVER['REQUEST_METHOD'];

$data=array();
 switch ($request) {
 	case 'GET':
 		  response(getData());
 		break;

 
    case 'POST':
 		  response(addData());
 		break;

     case 'PUT':
 		  response(updateData());
 		break;

        case 'DELETE':
 		  response(removeData());
 		break;

 	default:
 		# code...
 		break;
 }




  function getData(){
      global $conn;
     
     if(@$_GET['id']){
     	@$id=$_GET['id'];

     	$where="where id=".$id;
     }else{
     	$id=0;
     	$where="";
     }

      $query=mysqli_query($conn,"select * from user ".$where);
      while ($row=mysqli_fetch_assoc($query)) {
      	 $data[]=array("id"=>$row['id'],"name"=>$row['name'],"age"=>$row['age']);
      }
    return $data;
   }

function addData(){

	global $conn;

	$query=mysqli_query($conn,"insert into user(name,email,age)values('".$_POST['name']."','".$_POST['email']."','".$_POST['age']."')");

	if ($query==true) {
		$data[]=array("Message"=>"Created");
	}else{
		$data[]=array("Message"=>"Not Created !");
	}

return $data;
}

function updateData(){
	global $conn;

	parse_str(file_get_contents('php://input'),$_PUT);

	 if(@$_GET['id']){
     	@$id=$_GET['id'];

     	$where="where id=".$id;
     }else{
     	$id=0;
     	$where="";
     }

     $query=mysqli_query($conn,"update user set name='".$_PUT['name']."',  email='".$_PUT['email']."',age='".$_PUT['age']."' ".$where);

     	if ($query==true) {
		$data[]=array("Message"=>"update");
	}else{
		$data[]=array("Message"=>"Not update !");
	}
   return $data;
}

function removeData(){

	   global $conn;
     
     if(@$_GET['id']){
     	@$id=$_GET['id'];

     	$where="where id=".$id;
     }else{
     	$id=0;
     	$where="";
     }
     $query=mysqli_query($conn,"delete from user ".$where);

     	if ($query==true) {
		$data[]=array("Message"=>"delete");
	}else{
		$data[]=array("Message"=>"Not delete !");
	}
   return $data;
}


function response($data){
	echo  json_encode($data);
}

 ?>
