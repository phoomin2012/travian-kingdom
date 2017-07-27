<?php
include_once("engine/session.php");
if($_POST){
    if($_POST['ac']=="registerForm"){
        echo "
        <table class='table'>
            <tr>
                <td>ชื่อบัญชี :</td>
                <td>
					<div class='form-group usernameS1'>
						<input type='text' name='usernameS1' class='form-control input-sm' />
					</div>
				</td>
            </tr>
            <tr>
                <td>รหัสผ่าน :</td>
                <td>
					<div class='form-group passwordS1'>
						<input type='password' name='passwordS1' class='form-control input-sm' />
					</div>
				</td>
            </tr>
            <tr>
                <td>อีเมล์ :</td>
                <td>
					<div class='form-group emailS1'>
						<input type='email' name='emailS1' class='form-control input-sm' />
					</div>
				</td>
            </tr>
            <tr>
                <td colspan='2'><button type='button' data-loading-text='กำลังทำการลงทะเบียน...' class='btnServer1RegisterForm btn btn-success btn-block btn-small'>ลงทะเบียน (ข้าพเจ้ายอมรับกฏและเงื่อนไขต่างๆ)</button></td>
            </tr>
        </table>
        <script>
			var datasss = '';
            $('.btnServer1RegisterForm').click(function() {
				datasss = 'ac=registerSubmit&name=' + $(\"input[name='usernameS1']\").val() + '&pw=' + $(\"input[name='passwordS1']\").val() + '&email=' + $(\"input[name='emailS1']\").val()
                $.ajax({
                    url: 'ajax.php',
                    method: 'post',
                    data: datasss,
                    beforeSend: function() {
                        $('.btnServer1RegisterForm').button('loading');
                    },
                    success: function(result) {
						var data = $.parseJSON(result);
						$('.btnServer1RegisterForm').button('reset');
						if(data.length > 0 && result!='[]') {
							if(data['name']!='') {
								$('.usernameS1').addClass('has-error');
							}
							if(data['pw']!='') {
								$('.passwordS1').addClass('has-error');
							}
							if(data['email']!='') {
								$('.emailS1').addClass('has-error');
							}
						}else{
							$('.btnServer1RegisterForm').text('ลงทะเบียนเสร็จสิ้น');
							//window.location='index.php';
						}
                    },
                    error: function() {
                        $('.btnServer1RegisterForm').button('reset');
                        $('.btnServer1RegisterForm').text('พบข้อผิดพลาดในการลงทะเบียน กรุณาลองใหม่ภายหลัง');
                    }
                });
            });
        </script>
        ";
        exit();
    }
    if($_POST['ac']=="registerSubmit"){
        if($engine->account->Signup($_POST)){
            header('Content-type: application/json');
            echo "[]";
        }else{
            header('Content-type: application/json');
            echo json_encode(array('name'=>'E','pw'=>'E','email'=>'E'));
        }
    }
	if($_POST['ac']=="loginSubmit"){
        if($engine->account->Login($_POST)){
            header('Content-type: application/json');
            echo "[]";
        }else{
            header('Content-type: application/json');
            echo json_encode(array('name'=>'E','pw'=>'E'));
        }
	}
    if($_POST['ac']=="listServer"){
        header('Content-type: application/json');
        echo json_encode($engine->database->listServer());
    }
}else{
    echo "Access Denied";
    exit();
}
?>
