<html>
	<head>
	
	</head>
	
	<body>
		<table style="max-width:650px;margin:0 auto;font-family:'Work Sans',Helvetica,Arial,Verdana,sans-serif;color:#3a3a3b;background-image:url('http://files.enjin.com/500086/splash/bg-res.png');padding:50px;">
			<tbody>
				<tr>
					<td>
						<table style="width:100%;font-family:'Work Sans',Helvetica,Arial,Verdana,sans-serif;color:#3a3a3b">
							<tbody>
								<tr>
									<td>
										<table width="50%" align="left" class="responsive-header" style="font-family:'Work Sans',Helvetica,Arial,Verdana,sans-serif;color:#3a3a3b">
											<tbody>
												<tr>
													<td>
														<h1>MITRA<br>NOTARIS</h1>
													</td>
												</tr>
											</tbody>
										</table>
							
										<table width="50%" align="right" class="responsive-header" style="font-family:'Work Sans',Helvetica,Arial,Verdana,sans-serif;color:#3a3a3b;margin-top:25px">
											<tbody>
												<tr>
													<td style="text-align:right;color:#413e3f;font-size:12px">
														<a href="{{route('uac.login.create')}}" style="background-color:#0275d8;padding:10px 20px;border-radius:20px;color:white;text-decoration:none;font-size:13px;font-family:'Work Sans',Helvetica,Arial,Verdana,sans-serif" target="_blank">
															Login ›
														</a>
													</td>
												</tr>
											</tbody>
										</table>
									</td>
								</tr>
							</tbody>
						</table>
						<div class="responsive-body">
							<div style="padding:30px 40px;background:#fff;margin-bottom:20px"> 
								<p style="font-size:15px;margin:0 0 20px 0;line-height:1.8;font-weight:300;font-family:'Work Sans',Helvetica,Arial,Verdana,sans-serif">Hello {{$pengguna->nama}}
								</p>
								<p style="font-size:15px;margin:0 0 20px 0;line-height:1.8;font-weight:300;font-family:'Work Sans',Helvetica,Arial,Verdana,sans-serif">Seseorang telah meminta untuk reset <span class="il">password</span>.
								</p>
								<p style="font-size:15px;margin:0 0 20px 0;line-height:1.8;font-weight:300;font-family:'Work Sans',Helvetica,Arial,Verdana,sans-serif">
									Email Anda: <a href="mailto:chelsymooy1108@gmail.com" target="_blank">chelsymooy1108@gmail.com</a><br> Untuk <span class="il">reset</span> <span class="il">password</span> Anda <a href="{{route('uac.reset.edit', ['token' => $pengguna->reset_token])}}">klik disini</a>.
								</p>
								<p style="font-size:15px;margin:0 0 20px 0;line-height:1.8;font-weight:300;font-family:'Work Sans',Helvetica,Arial,Verdana,sans-serif">Jika Anda tidak meminta untuk reset password
									<a href="mailto:cs@mitranotaris.id" style="text-decoration:none;font-weight:300" target="_blank">informasikan pada kami</a>.
								</p>
								<p style="font-size:15px;margin:0 0 20px 0;line-height:1.8;font-weight:300;font-family:'Work Sans',Helvetica,Arial,Verdana,sans-serif">Semoga Hari Anda Menyenangkan!
								</p>

								<p style="font-size:15px;margin:40px 0 0 0;line-height:1.8;color:#35373b;font-weight:300;font-family:'Work Sans',Helvetica,Arial,Verdana,sans-serif">Mitra Notaris
								</p>
								<p></p><p></p>
							</div>
						</div>
						<table style="width:100%;font-size:13px;color:#35373b;font-family:'Work Sans',Helvetica,Arial,Verdana,sans-serif;line-height:18px;font-weight:300">
							<tbody>
								<tr>
									<td>
										<hr style="border:0;height:1px;margin:10px 0 10px">
									</td>
								</tr>
								<tr>
									<td style="text-align:center">
										<a class="social-link" href="https://www.facebook.com/mitranotaris" style="text-decoration:none" target="_blank">
											<img src="https://ci4.googleusercontent.com/proxy/50px4kr5Wd9fuHgCfrRoNFpERtSL5z2AqHiI21gjVUVCZeY1WPG_3iBiaEOWfsvD0cRe2fpK3mHqmAkKpPkog1rpCYU1Nro=s0-d-e1-ft#http://static.scoro.com/facebook_rounded_logo.png" height="25" width="25" class="CToWUd">
										</a>
										<a class="social-link" href="https://www.linkedin.com/company/mitranotaris" style="text-decoration:none" target="_blank">
											<img src="https://ci5.googleusercontent.com/proxy/n0WuAavGJoGKa9KQzQ9vEC28c46usWA643MYcxoDhjZUqqNBUKfxwwyKXEt1vJ5ajOUc4OjWNkOOuwrzWvNs455rulwOPV8=s0-d-e1-ft#http://static.scoro.com/linkedin_rounded_logo.png" height="25" width="25" class="CToWUd">
										</a>
										<a class="m_7408640854510296239social-link" href="https://twitter.com/mitranotaris" style="text-decoration:none" target="_blank">
						                        <img src="https://ci6.googleusercontent.com/proxy/p44oAX6Uen6FQBNCH8GLYUHCwG2nW22QpmZvomGZztlZt_Sr5WzEFYbPUrgR-z_NkP3aBsSvDujhHfxP7Ty74cnMSjB72A=s0-d-e1-ft#http://static.scoro.com/twitter_rounded_logo.png" height="25" width="25" class="CToWUd">
						                </a>
										<a class="social-link" href="https://plus.google.com/mitranotaris" style="text-decoration:none" target="_blank">
											<img src="https://ci5.googleusercontent.com/proxy/HE_7kDT3t-rj7IkAG6Qu-cpgPZD64zQAEYsJss_5jmUC581RpdHhfqK3uF4ly_ZmtXag3YizU0_oWVtlwttwI9OPesHYgIagiCk=s0-d-e1-ft#http://static.scoro.com/google_plus_rounded_logo.png" height="25" width="25" class="CToWUd">
										</a>
									</td>
								</tr>
							</tbody>
						</table>
						<table style="width:100%;font-size:13px;color:#35373b;font-family:'Work Sans',Helvetica,Arial,Verdana,sans-serif;line-height:18px;font-weight:300">
							<tbody>
								<tr>
									<td>
										<hr style="border:0;height:1px;margin:10px 0 10px">
									</td>
								</tr>
								<tr>
									<td style="text-align:center;font-size:13px;color:#35373b;font-family:'Work Sans',Helvetica,Arial,Verdana,sans-serif;line-height:18px;font-weight:300">
											© 2017 Mitra Notaris.  | <a href="https://www.mitranotaris.id" style="text-decoration:underline;color:#35373b;font-size:13px;color:#35373b;font-family:'Work Sans',Helvetica,Arial,Verdana,sans-serif;line-height:18px;font-weight:300" target="_blank">www.mitranotaris.id</a>
									</td>
								</tr>
								<tr>
									<td style="text-align:center;font-size:13px;color:#35373b;font-family:'Work Sans',Helvetica,Arial,Verdana,sans-serif;line-height:18px;font-weight:300">
										Mitra Notaris | Intiland Tower, Jl. Panglima Sudirman No.101-103 | Genteng, Surabaya
									</td>
								</tr>
							</tbody>
						</table>
						<table style="width:100%">
							<tbody>
								<tr>
									<td>
										<table width="100%" align="left" class="responsive-footer" style="margin-top:10px;font-size:13px;color:#35373b;font-family:'Work Sans',Helvetica,Arial,Verdana,sans-serif;line-height:18px;font-weight:300">
											<tbody>
												<tr>
													<td style="text-align:center;font-size:13px;color:#35373b;font-family:'Work Sans',Helvetica,Arial,Verdana,sans-serif;line-height:18px;font-weight:300">
														Jika ada pertanyaan silahkan menghubungi <a href="mailto:cs@mitranotaris.id" style="color:#35373b" target="_blank"><strong><u>Customer Support</u></strong> kami</a>.
													</td>
												</tr>
											</tbody>
										</table>
									</td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
			</tbody>
		</table>
	</body>
</html>