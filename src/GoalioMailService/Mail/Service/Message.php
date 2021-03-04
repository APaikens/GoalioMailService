<?php
namespace GoalioMailService\Mail\Service;

use Laminas\Mime\Mime;
use Laminas\ServiceManager\ServiceManager;
use Laminas\ServiceManager\ServiceManagerAwareInterface;
use Laminas\Mail\Message as MailMessage;
use Laminas\Mime\Message as MimeMessage;
use Laminas\Mime\Part as MimePart;

class Message {

    /**
     *
     * @var \Laminas\View\Renderer\RendererInterface
     */
    protected $renderer;

    /**
     *
     * @var \Laminas\Mail\Transport\TransportInterface
     */
    protected $transport;

    public function __construct($transport, $renderer)
    {
        $this->transport = $transport;
        $this->renderer = $renderer;
    }

    /**
     * Return a HTML message ready to be sent
     *
     * @param array|string $from
     *            A string containing the sender e-mail address, or if array with keys email and name
     * @param array|string $to
     *            An array containing the recipients of the mail
     * @param string $subject
     *            Subject of the mail
     * @param string|\Laminas\View\Model\ModelInterface $nameOrModel
     *            Either the template to use, or a ViewModel
     * @param null|array $values
     *            Values to use when the template is rendered
     * @return Message
     */
    public function createHtmlMessage($from, $to, $subject, $nameOrModel, $values = array()) {
        $renderer = $this->getRenderer();
        $content = $renderer->render($nameOrModel, $values);

        //skip adding empty text/plain part - as it is not actually used
        //$text = new MimePart('');
        //$text->type = "text/plain";

        $html = new MimePart($content);
        $html->type = "text/html; charset=UTF-8";
        $html->encoding = Mime::ENCODING_QUOTEDPRINTABLE;

        $body = new MimeMessage();
        //skip adding emptt text part
        //$body->setParts(array($text, $html));
        $body->setParts(array($html));

        return $this->getDefaultMessage($from, 'utf-8', $to, $subject, $body);
    }

    /**
     * Return a text message ready to be sent
     *
     * @param array|string $from
     *            A string containing the sender e-mail address, or if array with keys email and name
     * @param array|string $to
     *            An array containing the recipients of the mail
     * @param string $subject
     *            Subject of the mail
     * @param string|\Laminas\View\Model\ModelInterface $nameOrModel
     *            Either the template to use, or a ViewModel
     * @param null|array $values
     *            Values to use when the template is rendered
     * @return Message
     */
    public function createTextMessage($from, $to, $subject, $nameOrModel, $values = array()) {
        $renderer = $this->getRenderer();
        $content = $renderer->render($nameOrModel, $values);

        return $this->getDefaultMessage($from, 'utf-8', $to, $subject, $content);
    }

    /**
     * Send the message
     *
     * @param MailMessage $message
     */
    public function send(MailMessage $message) {
        $this->getTransport()
            ->send($message);
    }

    /**
     * Get the renderer
     *
     * @return \Laminas\View\Renderer\RendererInterface
     */
    public function getRenderer() {
        return $this->renderer;
    }

    /**
     * @param \Laminas\View\Renderer\RendererInterface $renderer
     *
     * @return $this
     */
    public function setRenderer($renderer) {
        $this->renderer = $renderer;

        return $this;
    }

    /**
     * Get the transport
     *
     * @return \Laminas\Mail\Transport\TransportInterface
     */
    public function getTransport() {
        return $this->transport;
    }

    /**
     * @param \Laminas\Mail\Transport\TransportInterface $transport
     *
     * @return $this
     */
    public function setTransport($transport) {
        $this->transport = $transport;

        return $this;
    }

    /**
     * @param $from
     * @param $encoding
     * @param $to
     * @param $subject
     * @param $body
     *
     * @return MailMessage
     */
    protected function getDefaultMessage($from, $encoding, $to, $subject, $body) {
        if(is_string($from)) {
            $from = array('email' => $from, 'name' => $from);
        }

        $message = new MailMessage();
        $message->setFrom($from['email'], $from['name'])
            ->setEncoding($encoding)
            ->setSubject($subject)
            ->setBody($body)
            ->setTo($to);

        return $message;
    }
}
