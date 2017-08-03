<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Domain\Admin\Models\Pengguna;

class SendResetPasswordToken extends Mailable
{
	use Queueable, SerializesModels;

	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct(Pengguna $pengguna)
	{
		$this->pengguna         = $pengguna;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		return $this->from('cs@notaris.id')
				->view('market_web.emails.password.reset_token')->with('pengguna', $this->pengguna);
	}
}
