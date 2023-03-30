<?php

namespace Tests\Unit;
use PHPUnit\Framework\TestCase;
use App\Mail\JustTesting;
use Illuminate\Support\Facades\Mail;
class MailerTest extends TestCase
{
   /**
    * A basic unit test example.
    *
    * @return void
    */
   public function testSending()
   {
       Mail::fake();
       Mail::send(new JustTesting());
       Mail::assertSent(JustTesting::class);
       Mail::assertSent(JustTesting::class, function ($mail) {
           $mail->build();
           $this->assertTrue($mail->hasFrom('noreplyr6@gmail.com'));
           $this->assertTrue($mail->hasCc('hola@mailtrap.io'));
           return true;
       });
   }
}
