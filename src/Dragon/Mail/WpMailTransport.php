<?php

namespace Dragon\Mail;

use Symfony\Component\Mailer\SentMessage;
use Symfony\Component\Mailer\Transport\AbstractTransport;
use Symfony\Component\Mime\MessageConverter;
use Symfony\Component\Mime\Email;

class WpMailTransport extends AbstractTransport {
	protected function doSend(SentMessage $message): void {
		$email = MessageConverter::toEmail($message->getOriginalMessage());
		foreach ($email->getTo() as $to) {
			wp_mail(
					$to->getAddress(),
					$email->getSubject(),
					$email->getTextBody(),
					[],
					$this->getAttachments($email)
					);
		}
	}
	
	public function __toString(): string
	{
		return 'wp_mail';
	}
	
	private function getAttachments(Email $email) {
		$out = [];
		$attachmentsBase = config('mail.mailers.wp_mail.attachments_path');
		$attachments = $email->getAttachments();
		if (empty($attachments)) {
			return [];
		}
		
		foreach ($attachments as $attachment) {
			$out[$attachment->getFilename()] = $attachmentsBase . '/' . $attachment->getFilename();
		}
		
		return $out;
	}
}
