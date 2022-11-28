<?php

include('../../includes/include-bdd.php');
include('../../includes/include-functions.php');
$id = $_GET['id'];

$req_user_info = $bdd->prepare('SELECT firstname, mail_verified FROM OMT_USER WHERE id_user = ?');
$req_user_info->execute(array($id));
$user_info = $req_user_info->fetch();

if($user_info['mail_verified'] == 0){
	$number = mt_rand(100000,999999);
	$req_update_mail_verified = $bdd->prepare('UPDATE OMT_USER SET mail_verified = ? WHERE id_user = ?');
	$req_update_mail_verified->execute(array($number,$id));
	$user_info['mail_verified'] = $number;
}
?>

<!DOCTYPE html>

<html lang="en" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:v="urn:schemas-microsoft-com:vml">

<head>
	<title></title>
	<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
	<meta content="width=device-width, initial-scale=1.0" name="viewport" />
	<style>
		* {
			box-sizing: border-box;
		}

		body {
			margin: 0;
			padding: 0;
		}

		p {
			line-height: inherit
		}		
	</style>
</head>

<body style="background-color: #FFFFFF; margin: 0; padding: 0; -webkit-text-size-adjust: none; text-size-adjust: none;">
	<table border="0" cellpadding="0" cellspacing="0" class="nl-container" role="presentation"
		style="   background-color: #FFFFFF;" width="100%">
		<tbody>
			<tr>
				<td>
					<table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-1"
						role="presentation" width="100%">
						<tbody>
							<tr>
								<td>
									<table align="center" border="0" cellpadding="0" cellspacing="0"
										class="row-content stack" role="presentation"
										style="   color: #000000; width: 500px;" width="500">
										<tbody>
											<tr>
												<td class="column column-1"
													style="   font-weight: 400; text-align: left; vertical-align: top; padding-top: 5px; padding-bottom: 5px; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;"
													width="100%">
													<table border="0" cellpadding="0" cellspacing="0"
														class="heading_block" role="presentation" width="100%">
														<tr>
															<td style="width:100%;text-align:center;">
																<h1
																	style="margin: 0; color: #555555; font-size: 23px; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; line-height: 120%; text-align: center; direction: ltr; font-weight: 700; letter-spacing: normal; margin-top: 0; margin-bottom: 0;">
																	<span class="tinyMce-placeholder">Bonjour <?= $user_info['firstname']?></span>
																</h1>
															</td>
														</tr>
													</table>
													<table border="0" cellpadding="10" cellspacing="0"
														class="divider_block" role="presentation" width="100%">
														<tr>
															<td>
																<div align="center">
																	<table border="0" cellpadding="0" cellspacing="0"
																		role="presentation" width="100%">
																		<tr>
																			<td class="divider_inner"
																				style="font-size: 1px; line-height: 1px; border-top: 1px solid #BBBBBB;">
																				<span> </span>
																			</td>
																		</tr>
																	</table>
																</div>
															</td>
														</tr>
													</table>
													<table border="0" cellpadding="10" cellspacing="0"
														class="paragraph_block" role="presentation"
														style="  word-break: break-word;" width="100%">
														<tr>
															<td>
																<div
																	style="color:#000000;font-size:14px;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;font-weight:400;line-height:120%;text-align:left;direction:ltr;letter-spacing:0px;">
																	<p style="margin: 0;">Nous sommes ravis de vous
																		voir. Tout d'abord, vous devez confirmer votre
																		email. Appuyez simplement sur le bouton
																		ci-dessous.</p>
																</div>
															</td>
														</tr>
													</table>
													<br><br>
													<table border="0" cellpadding="0" cellspacing="0"
														class="button_block" role="presentation" width="100%">
														<tr>
															<td>
																<div align="center">
																	<td align='center' style='border-radius: 3px;' bgcolor='#FFA73B'>
																		<a href='<?= checkhost().$_SERVER['HTTP_HOST']?>/validation.php?id=<?= $_GET['id']?>&pwd=<?= $user_info['mail_verified']?>' target='_blank' align='center' style='font-size: 20px; font-family: Helvetica, Arial, sans-serif; color: #ffffff; text-decoration: none; color: #ffffff; text-decoration: none; padding: 10px 10px; border-radius: 2px; display: inline-block;'>Confirmer votre email</a>
																	</td>
																</div>
															</td>
														</tr>
													</table>
													<br><br>
													<table border="0" cellpadding="10" cellspacing="0"
														class="paragraph_block" role="presentation"
														style="   word-break: break-word;" width="100%">
														<tr>
															<td>
																<div
																	style="color:#000000;font-size:14px;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;font-weight:400;line-height:120%;text-align:left;direction:ltr;letter-spacing:0px;">
																	<p style="margin: 0;">Si cela ne fonctionne pas,
																		copiez et collez le lien suivant dans votre
																		navigateur: <a target="_blank"
																		href="<?= checkhost().$_SERVER['HTTP_HOST']?>/validation.php?id=<?= $_GET['id']?>&pwd=<?= $user_info['mail_verified']?>"><?= checkhost().$_SERVER['HTTP_HOST']?>/validation.php?id=<?= $_GET['id']?>&pwd=<?= $user_info['mail_verified']?>
																	</a></p>
																</div>
															</td>
														</tr>
													</table>
													<br><br>
													<table border="0" cellpadding="10" cellspacing="0"
														class="divider_block" role="presentation" width="100%">
														<tr>
															<td>
																<div align="center">
																	<table border="0" cellpadding="0" cellspacing="0"
																		role="presentation" width="100%">
																		<tr>
																			<td class="divider_inner"
																				style="font-size: 1px; line-height: 1px; border-top: 1px solid #BBBBBB;">
																				<span> </span>
																			</td>
																		</tr>
																	</table>
																</div>
															</td>
														</tr>
													</table>
													<table border="0" cellpadding="0" cellspacing="0"
														class="heading_block" role="presentation" width="100%">
														<tr>
															<td style="width:100%;text-align:center;">
																<h1
																	style="margin: 0; color: #555555; font-size: 23px; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; line-height: 120%; text-align: center; direction: ltr; font-weight: 700; letter-spacing: normal; margin-top: 0; margin-bottom: 0;">
																	<span class="tinyMce-placeholder">L'équipe
																		OMT</span>
																</h1>
															</td>
														</tr>
													</table>
												</td>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
						</tbody>
					</table>
					<table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-2"
						role="presentation" width="100%">
						<tbody>
							<tr>
								<td>
									<table align="center" border="0" cellpadding="0" cellspacing="0"
										class="row-content stack" role="presentation"
										style="color: #000000; width: 500px;" width="500">
										<tbody>
											<tr>
												<td class="column column-1"
													style="   font-weight: 400; text-align: left; vertical-align: top; padding-top: 5px; padding-bottom: 5px; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;"
													width="100%">
													<table border="0" cellpadding="0" cellspacing="0"
														class="icons_block" role="presentation" width="100%">
														<tr>
															<td
																style="vertical-align: middle; color: #9d9d9d; font-family: inherit; font-size: 15px; padding-bottom: 5px; padding-top: 5px; text-align: center;">
																<table cellpadding="0" cellspacing="0"
																	role="presentation" width="100%">
																	<tr>
																		<td
																			style="vertical-align: middle; text-align: center;">
																			<table cellpadding="0" cellspacing="0"
																				class="icons-inner" role="presentation"
																				style=" display: inline-block; margin-right: -4px; padding-left: 0px; padding-right: 0px;">
																			</table>
																		</td>
																	</tr>
																</table>
															</td>
														</tr>
													</table>
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
	</table><!-- End -->
</body>

</html>