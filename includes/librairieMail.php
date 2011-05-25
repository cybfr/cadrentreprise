<?php
error_reporting(E_ALL);

// Form Mail +
//
// Loïc Bresler + modifs C.Roy
//
// Script permettant d'envoyer un mail grâce à un formulaire sur un site. Ce qu'il fait de plus que les autres
// c'est qu'il gère la priorité du message, les copies et permet d'envoyer un fichier joint si l'hébergeur le permet
// (en gros presque tous sauf Online et Nexen)
//		Le script utilise une version de la classe Mail() développée par Leo West (lwest.free.fr) et modifiée par mes soins.
//

define( "ERR_FONCTION_MAIL", 1 );
define( "ERR_ADRESSE_INVALIDE", 2 );
define( "ERR_OBJET_COURT", 3 );
define( "ERR_CORPS_COURT", 4 );
define( "ERR_TAILLE_PJ", 5 );
define( "ERR_CAPTCHA", 6 );
define( "ERR_ENVOI_BLOC", 7 );			//	pas vraiment une erreur !!!!

class Mail
	{
	var $sendto = array();
	var $from;
	var $msubject;
	var $acc = array();
	var $abcc = array();
	var $aattach = array();
	var $aattachname = array();
	var $priorities = array( '1 (Highest)', '2 (High)', '3 (Normal)', '4 (Low)', '5 (Lowest)' );
	var $errNum;
	var $errMsg;

	// Mail contructor
	function Mail()
		{
		$this->autoCheck( true );
		}

	//                autoCheck( $boolean )
	//                activate or desactivate the email addresses validator
	//                ex: autoCheck( true ) turn the validator on
	//                by default autoCheck feature is on
	function autoCheck( $bool )
		{
		if( $bool )
			$this->checkAddress = true;
		else
			$this->checkAddress = false;
		}

	//                Subject( $subject )
	//                define the subject line of the email
	//                $subject: any valid mono-line string
	function Subject( $subject )
		{
//echo "$subject";
		$this->msubject = "=?utf-8?B?"
			. base64_encode( strtr( $subject, "\r\n" , "  " ) )
			. "?=";
		}

	//                From( $from )
	//                set the sender of the mail
	//                $from should be an email address
	function From( $from )
		{
		$res = true;
		$this->from= $from;
		if( $this->checkAddress == true )
			$res = $this->CheckAdresses( $this->from );
		return $res;
		}

	// fonction To( $to )
	//		set the To ( recipient )
	//			$to : email address, accept both a single address or an array of addresses
	function To( $to )
		{
		// TODO : test validité sur to
		$res = true;
		if( is_array( $to ) )
			{
			for( $i=0; $i < count($to); $i++ )
				$this->sendto[$i] = $to[$i];
			}
		else
			$this->sendto[] = $to;
		if( $this->checkAddress == true )
			$res = $this->CheckAdresses( $this->sendto );
		return $res;
		}

	//                Cc()
	//                set the CC headers ( carbon copy )
	//                $cc : email address(es), accept both array and string
	function Cc( $cc )
		{
		if( is_array($cc) )
			$this->acc= $cc;
		else
			$this->acc[]= $cc;

		if( $this->checkAddress == true )
			$this->CheckAdresses( $this->acc );
		}

	//                Bcc()
	//                set the Bcc headers ( blank carbon copy ).
	//                $bcc : email address(es), accept both array and string
	function Bcc( $bcc )
		{
		if( is_array($bcc) )
			$this->abcc = $bcc;
		else
			$this->abcc[]= $bcc;

		if( $this->checkAddress == true )
			$this->CheckAdresses( $this->abcc );
		}

	//	fonction Body()
	//                set the body of the mail ( message )
	function Body( $body )
		{
		$this->body= $body;
		}

	//	Send()
	//                fornat and send the mail
	//
	function Send()
		{
		// build the headers
		$this->_build_headers();

		// include attached files
		if( isset( $this->aattach[0] ) )
			{
			$this->_build_attachement();
			$body = $this->fullBody . $this->attachment;
			}
		else
			{
			$this->headers .= "Content-type: text/plain; charset=\"utf-8\"\n";

			$body = $this->body;
			}

		// envoi du mail aux destinataires principaux
//		if( count($this->abcc) > 0 )
//			$res = mail( '', $this->msubject, $body, $this->headers );
//		else
			{
			for( $i=0; $i< sizeof( $this->sendto ); $i++ )
				{
				$res = mail( $this->sendto[$i], $this->msubject, $body, $this->headers );
				if( ! $res ) break;
				}
			}
		if( ! $res )
			{
			$this->errNum = ERR_FONCTION_MAIL;
			return false;
			}
		return true;
		}

	//                Organization( $org )
	//                set the Organisation header
	function Organization( $org )
		{
		if( trim( $org != "" )  )
			$this->organization= $org;
		}

	//                Priority( $priority )
	//                set the mail priority
	//                $priority : integer taken between 1 (highest) and 5 ( lowest )
	//                ex: $m->Priority(1) ; => Highest
	function Priority( $priority )
		{
		if( ! intval( $priority ) )
			return false;

		if( ! isset( $this->priorities[$priority-1]) )
			return false;

		$this->priority= $this->priorities[$priority-1];

		return true;

		}

	//                Attach( $filepath, $filename, $filetype )
	//                attach a file to the mail
	//                $filepath : path of the file to attach (fichier temporaire PHP
	//                $filename : nom du fichier attaché
	//                $filetype : MIME-type of the file. default to 'application/x-unknown-content-type'
	//                $disposition : instruct the Mailclient to display the file
	//					if possible ("inline") or always as a link ("attachment")
	//						possible values are "inline", "attachment"
	function Attach( $filepath, $filename, $filetype='application/x-unknown-content-type', $disposition = "inline" )
		{
		// TODO : si filetype="", alors chercher dans un tablo de MT connus / extension du fichier
		$this->aattach[] = $filepath;
		$this->aattachname[] = $filename;
		$this->actype[] = $filetype;
		$this->adispo[] = $disposition;
		}

	//                Get()
	//                return the whole e-mail , headers + message
	//                can be used for displaying the message in plain text or logging it
	function Get()
		{
		$this->_build_headers();
		if( sizeof( $this->aattach ) > 0 )
			{
			$this->_build_attachement();
			$this->body= $this->body . $this->attachment;
        	}
		$mail = $this->headers;
		$mail .= "\n$this->body";
		return $mail;
		}

	//	fonction ValidEmail( $email )
	//		return true if email adress is ok - regex from Manuel Lemos (mlemos@acm.org)
	//			$address : email address to check
	function ValidEmail( $address, $leMail )
		{
		if( ereg( ".*<(.+)>", $address, $regs ) )
			$address = $regs[1];

		if( !ereg( "^[^@  ]+@([a-zA-Z0-9\-]+\.)+([a-zA-Z0-9\-]{2}|net|com|gov|mil|org|edu|int)\$",$address) )
			return false;
		return true;
		}

	// fonction CheckAdresses()
	//		check validity of email addresses
	//		if unvalid, output an error message and exit, this may be customized
	//			$aad : array of emails addresses
	function CheckAdresses( $aad )
		{
//echo "CheckAdress: ";echo is_array($aad)==1?"table":"Ntable";echo "<br>";
		if( is_array( $aad ) )
			{
			for( $i=0; $i< sizeof( $aad ); $i++ )
				{
				$res = $this->ValidEmail( $aad[ $i ], $this );
				if( $res == false )
					break;
				} 
			}
		else
			$res = $this->ValidEmail( $aad, $this );
		if( ! $res )
			{
			$this->errNum = ERR_ADRESSE_INVALIDE;
			$this->errMsg = $aad;
			}
		return $res;
		}

	/********************** PRIVATE METHODS BELOW **********************************/

	//                _build_headers()
	//                 [INTERNAL] build the mail headers
	function _build_headers()
		{

		// creation du header mail
		$this->headers= "Reply-To: $this->from\n";

		$this->to= implode( ", ", $this->sendto );

		if( count($this->acc) > 0 )
			{
			$this->cc= implode( ", ", $this->acc );
			$this->headers .= "CC: $this->cc\n";
        	}

		if( count($this->abcc) > 0 )
			{
			$this->bcc= implode( ", ", $this->abcc );
			$this->headers .= "BCC: $this->bcc\n";
        	}

//        if( $this->organization != ""  )
//              $this->headers .= "Organization: $this->organization\n";

//        if( $this->priority != "" )
//                $this->headers .= "X-Priority: $this->priority\n";

		}

	//                _build_attachement()
	//                internal use only - check and encode attach file(s)
	function _build_attachement()
		{
		$this->boundary= "------------" . md5( uniqid("myboundary") ); // TODO : variable bound

		$this->headers .= "MIME-Version: 1.0\nContent-Type: multipart/mixed;\n boundary=\"$this->boundary\"\n\n";
		$this->fullBody = "This is a multi-part message in MIME format.\n--$this->boundary\nContent-Type: text/plain; charset=utf-8\n"
			. "Content-Transfer-Encoding: 7bit\n\n" . $this->body ."\n";
		$sep= chr(13) . chr(10);

		$ata= array();
		$k=0;

		// for each attached file, do...
		for( $i=0; $i < sizeof( $this->aattach); $i++ )
			{
			$filename = $this->aattach[$i];
			$basename = $this->aattachname[$i];
			$ctype = $this->actype[$i];        // content-type
			$disposition = $this->adispo[$i];
 			if( ! file_exists( $filename) )
				{
				echo "Class Mail, method attach : file $filename can't be found";
				exit;
				}
			$subhdr= "--$this->boundary\nContent-type: $ctype;\n name=\"$basename\"\nContent-Transfer-Encoding: base64\nContent-Disposition: $disposition;\n  filename=\"$basename\"\n";
			$ata[$k++] = $subhdr;
			// non encoded line length
			$linesz= filesize( $filename)+1;
			$fp= fopen( $filename, 'r' );
			$data= base64_encode(fread( $fp, $linesz));
			fclose($fp);
			$ata[$k++] = chunk_split( $data );
        	}
		$this->attachment= implode($sep, $ata);
		}

	} // fin de classe Mail 
