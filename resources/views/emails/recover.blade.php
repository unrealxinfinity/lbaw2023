<h3>Hi {{ $mailData['name'] }},</h3>
<h4>It seems you are trying to recover your MineMax password.</h4>
<p>To recover your password, <a href={{ $mailData['link'] }}>click here</a>. If you did not send a request to reset your password, ignore this email.</p>
<h5>Regards,</h5>
<h5>The MineMax staff</h5>