<?php


namespace App\Package\Email\src;


use PHPMailer\PHPMailer\PHPMailer;

class Email
{
    /** @var 设置邮件的字符编码，这很重要，不然中文乱码 */
    private $charset;

    /** @var port */
    private $port;

    /** @var host */
    private $host;

    /** @var 发件人 */
    private $from;

    /** @var smtp密码 */
    private $password;

    /** @var 使用安全协议 */
    private $smtpSecure;

    public function __construct()
    {
        $config = config('email.default');
        if (empty($config)) {
            throw new \Exception('邮件配置异常');
        }
        $this->charset = $config['charset'];
        $this->port = $config['port'];
        $this->host = $config['host'];
        $this->from = $config['from'];
        $this->password = $config['password'];
        $this->smtpSecure = $config['smtp_secure'];
    }

    /**
     * 发送邮件
     *
     * @param $toEmail
     * @param $subject
     * @param $content
     * @return bool
     * @throws \PHPMailer\PHPMailer\Exception
     */
    public function send($toEmail, $subject, $body)
    {
        try {
            $mail = new PHPMailer();
            //$mail->SMTPDebug = 1;
            $mail->IsSMTP();
            //设置邮件的字符编码，这很重要，不然中文乱码
            $mail->CharSet = $this->charset;
            //开启认证
            $mail->SMTPAuth = true;
            //使用安全协议
            $mail->SMTPSecure = $this->smtpSecure;
            //端口请保持默认
            $mail->Port = $this->port;
            //smtp服务器
            $mail->Host = $this->host;
            //这个可以替换成自己的邮箱
            $mail->Username = $this->from;
            //smtp密码，如果是qq邮箱则是授权码
            $mail->Password = $this->password;
            //发件人邮箱
            $mail->From = $this->from;
            //发件人名称
            $mail->FromName = 'Ranblogs';
            //收件人
            $mail->AddAddress($toEmail);
            //邮件主题
            $mail->Subject = $subject;
            //body
            $mail->Body = $body;
            $mail->IsHTML(true);
            $mail->Send();
        } catch (phpmailerException $e) {
            throw new \Exception($e->getMessage());
        }
        return true;
    }

    /**
     * 基础模板 - 验证码模板
     *
     * @param $code
     * @return string
     */
    public function templateCode($code)
    {
        return '<html><head>
<meta http-equiv="Content-Language" content="zh-cn">
<meta http-equiv="Content-Type" content="text/html; charset=GB2312"></head>
<body>
' . $code . '
</body>
</html>';
    }

}