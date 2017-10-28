<?php
	class UserCenterController {
		public function login() {
				include "./view/usercenter/login.html";
		}
		public function doLogin() {
				$email = $_POST['email'];
				$password = $_POST['password'];
				$verifyCode=$_POST['verify'];
				$userModel =  new UserModel();
				$userInfo = $userModel->getUserInfoByEmail($email);
			if (empty($email) || empty($password) || empty($verifyCode)) {       
       			header ('Refresh:2,Url=index.php?c=UserCenter&a=login');
       			echo "用户名或密码错误，登录不成功";
       			die();
       		}
       		if ($_SESSION['verifyCode']!=$verifyCode) {
       			header ('Refresh:2,Url=index.php?c=UserCenter&a=login');//三秒后跳转
       			echo "验证码错误，登录不成功";
       			die();	
       		}
			if ($userInfo['password'] == $password) {
				unset($userInfo['password']); //一般来说 密码对外开放
				$_SESSION['me'] = $userInfo;
				header('Refresh:1,Url=index.php?c=Home&a=index');
				echo '登录成功';
				die();
			} else {
				header('Refresh:2,Url=index.php?c=UserCenter&a=login');
				echo '1用户名或密码错误，登录不成功';
				die();
			}
		}
		public function reg () {
			include "./view/usercenter/reg.html";
		}
		public function doReg() {
			$upload =L("Upload");
			$image = $upload->run('photo');
			$name 	= $_POST['name'];
			$email 	= $_POST['email'];
			$password = $_POST['password'];			
			if (empty($name) || empty($password)) {
				header('Refresh:2,Url=index.php?c=UserCenter&a=reg');
				echo '用户名或密码为空，注册不成功';
				die();
			}
			$userModel = new UserModel();
			$userInfo = $userModel->getUserInfoByEmail($email);
			if (!empty($userInfo)) {
				header('Refresh:1,Url=index.php?c=UserCenter&a=reg');
				echo '邮箱已存在，注册失败';
				die();
			}
			$status = $userModel->addUser($name,$email,$password,$image);
			if ($status) {
				header('Refresh:1,Url=index.php?c=UserCenter&a=login');
				echo '注册成功，1秒后跳转';
				die();
			} else {
				header('Refresh:2,Url=index.php?c=UserCenter&a=reg');
				echo '参数错误，2秒后跳转';
				die();
			}
		}
		public function logout () {
				unset($_SESSION['me']);
				header('Refresh:1,Url=index.php?c=Home&a=index');
				echo '注销成功';
				die();
		}
		public function userInfo() {
			$user_id = $_SESSION['me']['id'];
			$userModel = new UserModel();
			$userInfo = $userModel->getUserInfo();
			include "./view/usercenter/userInfo.html";
		}
		public function	editUserInfo() {
			$user_id = $_SESSION['me']['id'];
			$userModel = new UserModel();
			$userInfo = $userModel->getUserInfo();
			include "./view/usercenter/edit.html";
		}
		public function doEditUserInfo() {
			$id = $_POST['id'];
			$name = $_POST['name'];
			$email = $_POST['email'];
			$password = $_POST['password'];
			$upload =L("Upload");
			$image = $upload->run('image');
			$userModel = new UserModel();
			$status = $userModel->editUserInfo($name,$email,$password,$image,$id);
			if ($status) {
				header('Refresh:1,Url=index.php?c=UserCenter&a=userInfo');
				echo '修改成功，1秒后跳转';
				die();
			}
		}
		public function verifyCode() {
			header("Content-Type:image/png");

			$img = imagecreate(50, 25);

			$back = imagecolorallocate($img, 0xFF, 0xFF, 0xFF);

			$red = imagecolorallocate($img, 255, 0, 0);


			$str = getRandom(4) ;
			$_SESSION['verifyCode'] = $str;
			imagestring($img, 5, 7, 5, $str, $red);

			imagepng($img);

			imagedestroy($img);
		}	

	}