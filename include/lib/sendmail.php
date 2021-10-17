<?php

class SendMail {
	function send($to, $title, $content) {
		$mail = new PHPMailer(true);

		$mail->IsSMTP();                          // stmp 使用smtp鉴权方式发送邮件
		$mail->CharSet = 'UTF-8';                 // 设置邮件的字符编码，这很重要，不然中文乱码
		$mail->SMTPAuth = true;                   // 开启认证
		$mail->SMTPSecure = 'ssl';                // 设置使用ssl加密方式登录鉴权
		$mail->Port = 465;                        // 端口,设置ssl连接smtp服务器的远程服务器端口号，以前的默认是25，但是现在新的好像已经不可用了 可选465或587
		$mail->Host = "smtp.qq.com";              // 链接qq域名邮箱的服务器地址  smtp.sina.com.cn    smtp.163.com   smtp.qiye.163.co
		$mail->Hostname = '';                     // 设置发件人的主机域 可有可无 默认为localhost 内容任意，建议使用你的域名
		$mail->Username = "emlog@qq.com";         // 邮箱账号
		$mail->Password = "pblcisetsocdbjdh";     // STMP授权码  上面提到需要保存使用的
		$mail->From = "emlog@qq.com";
		$mail->FromName = "测试邮件STMP发送";
		if (is_array($to)) { #多人接收
			foreach ($to as $value) {
				$mail->AddAddress($value);
			}
		} else {                    #单人接收
			$mail->AddAddress($to); #抄送
		}

		$mail->Subject = $title;

		//添加邮件正文 上方将isHTML设置成了true，则可以是完整的html字符串 如：使用file_get_contents函数读取本地的html文件
		$mail->Body = $content;

		//为该邮件添加附件 该方法也有两个参数 第一个参数为附件存放的目录（相对目录、或绝对目录均可） 第二参数为在邮件附件中该附件的名称
		//$mail->addAttachment('./1.png,'图片');
		//同样该方法可以多次调用 上传多个附件
		//$mail->addAttachment('./test.php','php文件');

		$mail->WordWrap = 80; // 设置每行字符串的长度
		$mail->IsHTML(true);
		$ret = $mail->Send();
		return $ret;
	}

}
