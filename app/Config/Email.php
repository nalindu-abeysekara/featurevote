<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Email extends BaseConfig
{
    /**
     * Default user agent.
     */
    public string $userAgent = 'CodeIgniter';

    /**
     * Mail protocol (mail, sendmail, or smtp).
     */
    public string $protocol = 'mail';

    /**
     * SMTP Server.
     */
    public string $SMTPHost = '';

    /**
     * SMTP Username.
     */
    public string $SMTPUser = '';

    /**
     * SMTP Password.
     */
    public string $SMTPPass = '';

    /**
     * SMTP Port.
     */
    public int $SMTPPort = 465;

    /**
     * SMTP Timeout (seconds).
     */
    public int $SMTPTimeout = 5;

    /**
     * Enable TLS/SSL for SMTP.
     */
    public bool $SMTPKeepAlive = false;

    /**
     * SMTP Encryption (tls or ssl).
     */
    public string $SMTPCrypto = 'tls';

    /**
     * Wordwrap.
     */
    public bool $wordWrap = true;

    /**
     * Characters to wrap at.
     */
    public int $wrapChars = 76;

    /**
     * Mail type (text or html).
     */
    public string $mailType = 'html';

    /**
     * Character set (utf-8, iso-8859-1, etc.).
     */
    public string $charset = 'UTF-8';

    /**
     * Validate email addresses.
     */
    public bool $validate = false;

    /**
     * Email priority (1-5).
     */
    public int $priority = 3;

    /**
     * Newline character.
     */
    public string $CRLF = "\r\n";

    /**
     * Newline character for sending.
     */
    public string $newline = "\r\n";

    /**
     * Enable BCC Batch Mode.
     */
    public bool $BCCBatchMode = false;

    /**
     * BCC Batch Size.
     */
    public int $BCCBatchSize = 200;

    /**
     * Enable notify message from server.
     */
    public bool $DSN = false;

    /**
     * Sendmail path.
     */
    public string $mailPath = '/usr/sbin/sendmail';

    /**
     * From email address.
     */
    public string $fromEmail = '';

    /**
     * From name.
     */
    public string $fromName = 'FeatureVote';

    public function __construct()
    {
        parent::__construct();

        // Load from environment variables if available
        if (getenv('email.protocol')) {
            $this->protocol = getenv('email.protocol');
        }
        if (getenv('email.SMTPHost')) {
            $this->SMTPHost = getenv('email.SMTPHost');
        }
        if (getenv('email.SMTPUser')) {
            $this->SMTPUser = getenv('email.SMTPUser');
        }
        if (getenv('email.SMTPPass')) {
            $this->SMTPPass = getenv('email.SMTPPass');
        }
        if (getenv('email.SMTPPort')) {
            $this->SMTPPort = (int) getenv('email.SMTPPort');
        }
        if (getenv('email.SMTPCrypto')) {
            $this->SMTPCrypto = getenv('email.SMTPCrypto');
        }
        if (getenv('email.fromEmail')) {
            $this->fromEmail = getenv('email.fromEmail');
        }
        if (getenv('email.fromName')) {
            $this->fromName = getenv('email.fromName');
        }
    }
}
