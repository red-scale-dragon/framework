<?php

namespace Dragon\Mail;

use Symfony\Component\Mailer\SentMessage;
use Symfony\Component\Mailer\Transport\AbstractTransport;
use Symfony\Component\Mime\MessageConverter;

class WpMailTransport extends AbstractTransport {
	protected function doSend(SentMessage $message): void {
		$email = MessageConverter::toEmail($message->getOriginalMessage());
		$body = $email->getHtmlBody() ?? $email->getTextBody();
		
		foreach ($email->getTo() as $to) {
			$address = $to->getAddress();
			wp_mail($address, $email->getSubject(), $body);
		}
	}
	
	public function __toString(): string
	{
		return 'wp_mail';
	}
}
