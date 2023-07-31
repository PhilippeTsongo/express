<?php
/**
 * Email
 * @author Ezechiel Kalengya Ezpk [ezechielkalengya@gmail.com]
 * Software Developer 
 */

class EmailController
{

  /* ++++++++++  SENDING EMAILS ON CNS STORE PLATFORM BEGIN +++++++++++ */


  // send Email To Store User B2b On Register
  public static function sendEmailToB2BOnAdminCreateAccount($_data_)
  {
    $_data_ = (object) $_data_;
    $email = $_data_->email;
    $firstname = $_data_->firstname;
    $password = $_data_->password;
    $platform_name = $_data_->platform_name;
    $link = $_data_->link;

    $_Email_ = $email;
    $_Subject_ = 'CNS Platform Acccount Creation ' . $platform_name;
    $_Message_ = self::emailSectionHeaderLayout() . "
      
      <tr>
      <td class='innerpadding borderbottom'>
        <table width='100%' border='0' cellspacing='0' cellpadding='0'>
          <tr>
          <td class='h2' style='font-family: calibri; padding: 15px 0px 30px 0px; '>Salut! Cher <b>$firstname</b>,</td>
          </tr>
          <tr>
          <tr>
            <tr>
              <td class='h2' style='font-family: calibri;'>Merci d'avoir créer un compte sur notre plateforme, <b> $platform_name est trop efficasse, moderne et securiser</b> qui vous offre un espace de travail complex et rapide, fecile à utiliser.
              Cliquez sur le bouton ci-dessous pour vous connectez et commencez à profiter de nos service. Crois-moi, vous allez adorez <i class='fa fa-laugh'></i>
            </tr>
            <td>
              <p class='h2' style='font-family: calibri;'><a href='#' class='btn btn-primary text-white'><i class='fa fa-sign-in'></i> Connexion</a></p>
            </td>
            <tr>
              <td class='h2' style='font-family: calibri;padding: 15px 0;'><b>Si vous avez une question ou proposition, vous pouvez juste nous ecrire a info@cnsplateforme.com et on vous repondra a tout moment.</b> </td></tr>
                      
                        <tr>
                          <td class='h2' style='font-family: calibri;'>
                              <p>Email:  " . $email . "</p>
                              <p>Password: " . $password . "</p>
                              <p>System Link: <a href='" . $link . "'>" . $link . "</a></p>
                          </td>
                  </tr>
          </tr>
        </table>
      </td>
    </tr>
      
      " . self::emailLayoutSectionFooter();
    $Email = new \Email();
    return $Email->send($_Subject_, $_Message_, $_Email_, $firstname);
  }
  // send Email To Store User B2b On Register

  // send Email To Store User B2b On Register
  public static function sendEmailToStoreUserB2bOnRegister($_data_)
  {
    $_data_ = (object) $_data_;
    $email = $_data_->email;
    $firstname = $_data_->firstname;
    $platform_name = $_data_->platform_name;
    $link = $_data_->platforme_link;

    $_Email_ = $email;
    $_Subject_ = 'VERIFICATION EMAIL - ' . $platform_name;
    $_Message_ = self::emailSectionHeaderLayout() . "
     
     <tr>
     <td class='innerpadding borderbottom'>
       <table width='100%' border='0' cellspacing='0' cellpadding='0'>
         <tr>
         <td class='h2' style='font-family: calibri; padding: 15px 0px 30px 0px; '>Salut! Cher <b>$firstname</b>,</td>
         </tr>
         <tr>
         <tr>
           <tr>
             <td class='h2' style='font-family: calibri;'>Merci d'avoir créer un compte sur notre plateforme, <b> $platform_name est trop efficasse, moderne et securiser</b> qui vous offre un espace de travail complex et rapide, facile à utiliser.
             Cliquez sur le bouton ci-dessous pour vous connectez et commencez à profiter de nos service. Crois-moi, vous allez adorez <i class='fa fa-laugh'></i>
           </tr>
           <td>
             <p class='h2' style='font-family: calibri;'><a href='$link' class='btn btn-primary text-white'><i class='fa fa-sign-in'></i> Connexion</a></p>
           </td>
           <tr>
             <td class='h2' style='font-family: calibri;padding: 15px 0;'><b>Si vous avez une question ou proposition, vous pouvez juste nous ecrire a info@cnsplateforme.com et on vous repondra a tout moment.</b> </td></tr>
                     
                       <tr>
                         <td class='h2' style='font-family: calibri;'>
                             <p>Pour plus de details visiter <a href='https://cnsplateforme.com'>CNS Plateforme</a></p>
                         </td>
                 </tr>
         </tr>
       </table>
     </td>
   </tr>
     
     " . self::emailLayoutSectionFooter();
    $Email = new \Email();
    return $Email->send($_Subject_, $_Message_, $_Email_, $firstname);
  }
  // send Email To Store User B2b On Register

  // send Email To Store User B2b On Register
  public static function sendEmailToTontineUserB2bOnRegister($_data_)
  {
    $_data_ = (object) $_data_;
    $email = $_data_->email;
    $firstname = $_data_->firstname;
    $platform_name = $_data_->platform_name;

    $_Email_ = $email;
    $_Subject_ = 'VERIFICATION EMAIL - ' . $platform_name;
    $_Message_ = self::emailSectionHeaderLayout() . "
     
     <tr>
     <td class='innerpadding borderbottom'>
       <table width='100%' border='0' cellspacing='0' cellpadding='0'>
         <tr>
         <td class='h2' style='font-family: calibri; padding: 15px 0px 30px 0px; '>Salut! Cher <b>$firstname</b>,</td>
         </tr>
         <tr>
         <tr>
           <tr>
             <td class='h2' style='font-family: calibri;'>Merci d'avoir créer un compte sur notre plateforme, <b> $platform_name est trop efficasse, moderne et securiser</b> qui vous offre un espace de travail complex et rapide, fecile à utiliser.
             Cliquez sur le bouton ci-dessous pour vous connectez et commencez à profiter de nos service. Crois-moi, vous allez adorez <i class='fa fa-laugh'></i>
           </tr>
           <td>
             <p class='h2' style='font-family: calibri;'><a href='#' class='btn btn-primary text-white'><i class='fa fa-sign-in'></i> Connexion</a></p>
           </td>
           <tr>
             <td class='h2' style='font-family: calibri;padding: 15px 0;'><b>Si vous avez une question ou proposition, vous pouvez juste nous ecrire a info@cnsplateforme.com et on vous repondra a tout moment.</b> </td></tr>
                     
                       <tr>
                         <td class='h2' style='font-family: calibri;'>
                             <p>Pour plus de details visiter <a href='http://cnsplateforme.com'>CNS Plateforme</a></p>
                         </td>
                 </tr>
         </tr>
       </table>
     </td>
   </tr>
     
     " . self::emailLayoutSectionFooter();
    $Email = new \Email();
    return $Email->send($_Subject_, $_Message_, $_Email_, $firstname);
  }
  // send Email To Store User B2b On Register


  // send Email To Store User B2b On Reset Password
  public static function sendEmailToStoreUserB2bOnResetPassword($_data_)
  {
    $_data_ = (object) $_data_;
    $email = $_data_->email;
    $firstname = $_data_->firstname;
    $platform_name = $_data_->platform_name;
    $new_password = $_data_->new_password;

    $_Email_ = $email;
    $_Subject_ = 'Réinitialiser le mot de passe - ' . $platform_name;
    $_Message_ = self::emailSectionHeaderLayout() . "
     
     <tr>
     <td class='innerpadding borderbottom'>
       <table width='100%' border='0' cellspacing='0' cellpadding='0'>
         <tr>
         <td class='h2' style='font-family: calibri; padding: 15px 0px 30px 0px; '>Salut! Cher <b>$firstname</b>,</td>
         </tr>
         <tr>
         <tr>
           <tr>
             <td class='h2' style='font-family: calibri;'>Votre mot de pass $platform_name à été réinitialisé avec succes,
             $new_password est votre nouveau mot de pass, pour une question de securiter veuillez le modifier apres avoir vous connectez
             ou soit memorise-le et supprimer cet email dans votre boite email.
           </tr>
           <td>
             <p>Vous avez reussi cet email par erreur? Vous n'avez pas demander la réinitialisation de votre compte? </p>
             <div class='row'>
               <div class='col-md-6'>
                  <p class='h2' style='font-family: calibri;'><a href='#' class='btn btn-success text-white'>Annulez la réinitialisation</a></p>
               </div>
               <div class='col-md-6'>
                  <p class='h2' style='font-family: calibri;'><a href='' class='btn btn-danger text-white' onclick='return confirm('Cette action est irreversible')'>Confirmer la réinitialisation</a></p>
               </div>
             </div>
           </td>
           <tr>
             <td class='h2' style='font-family: calibri;padding: 15px 0;'><b>Si vous avez une question ou proposition, vous pouvez juste nous ecrire a info@cnsplateforme.com et on vous repondra a tout moment.</b> </td></tr>
                     
                       <tr>
                         <td class='h2' style='font-family: calibri;'>
                             <p>Pour plus de details, visiter <a href='http://cnsplateforme.com'>CNS Plateforme.com</a></p>
                         </td>
                 </tr>
         </tr>
       </table>
     </td>
   </tr>
     
   " . self::emailLayoutSectionFooter();
   $Email = new \Email();
   return $Email->send($_Subject_, $_Message_, $_Email_, $firstname);
  }
  //send Email To Store User B2b On Reset Password


  /* ++++++++++  SENDING EMAILS ON CNS STORE PLATFORM END  +++++++++++ */





  /* ++++++++++  SENDING EMAILS ON CNS EVENT PLATFORM BEGIN +++++++++++ */

  // send Email To event User B2b On Register
  public static function sendEmailToEventUserB2bOnRegister($_data_)
  {
    $_data_ = (object) $_data_;
    $email = $_data_->email;
    $firstname = $_data_->firstname;
    $platform_name = $_data_->platform_name;

    $_Email_ = $email;
    $_Subject_ = 'VERIFICATION EMAIL - ' . $platform_name;
    $_Message_ = self::emailSectionHeaderLayout() . "
     
     <tr>
     <td class='innerpadding borderbottom'>
       <table width='100%' border='0' cellspacing='0' cellpadding='0'>
         <tr>
         <td class='h2' style='font-family: calibri; padding: 15px 0px 30px 0px; '>Salut! Cher <b>$firstname</b>,</td>
         </tr>
         <tr>
         <tr>
           <tr>
             <td class='h2' style='font-family: calibri;'>Merci d'avoir créer un compte sur notre plateforme, <b> $platform_name est tres efficace, moderne et securiser</b> qui vous offre un espace de travail complex et rapide, fecile à utiliser.
             Cliquez sur le bouton ci-dessous pour vous connectez et commencez à profiter de nos service. Crois-moi, vous allez adorez <i class='fa fa-laugh'></i>
           </tr>
           <td>
             <p class='h2' style='font-family: calibri;'><a href='#' class='btn btn-primary text-white'><i class='fa fa-sign-in'></i> Connexion</a></p>
           </td>
           <tr>
             <td class='h2' style='font-family: calibri;padding: 15px 0;'><b>Si vous avez une question ou proposition, vous pouvez juste nous ecrire a info@cnsplateforme.com et on vous repondra a tout moment.</b> </td></tr>
                     
                       <tr>
                         <td class='h2' style='font-family: calibri;'>
                             <p>Pour plus de details visiter <a href='http://cnsplateforme.com'>CNS Plateforme</a></p>
                         </td>
                 </tr>
         </tr>
       </table>
     </td>
   </tr>
     
     " . self::emailLayoutSectionFooter();
    $Email = new \Email();
    return $Email->send($_Subject_, $_Message_, $_Email_, $firstname);
  }
  // send Email To Event User B2b On Register

  // send Email To Event User B2b On Reset Password
  public static function sendEmailToEventUserB2bOnResetPassword($_data_)
  {
    $_data_ = (object) $_data_;
    $email = $_data_->email;
    $firstname = $_data_->firstname;
    $platform_name = $_data_->platform_name;
    $new_password = $_data_->new_password;

    $_Email_ = $email;
    $_Subject_ = 'Réinitialiser le mot de passe - ' . $platform_name;
    $_Message_ = self::emailSectionHeaderLayout() . "
   
   <tr>
   <td class='innerpadding borderbottom'>
     <table width='100%' border='0' cellspacing='0' cellpadding='0'>
       <tr>
       <td class='h2' style='font-family: calibri; padding: 15px 0px 30px 0px; '>Salut! Cher <b>$firstname</b>,</td>
       </tr>
       <tr>
       <tr>
         <tr>
           <td class='h2' style='font-family: calibri;'>Votre mot de pass à été réinitialisé avec succes,
           $new_password est votre nouveau mot de pass, pour une question de securiter veuillez le modifier apres avoir vous connectez
           ou soit memorise-le et supprimer cet email dans votre boite email.
         </tr>
         <td>
           <p>Vous avez reussi cet email par erreur? Vous n'avez pas demander la réinitialisation de votre compte? </p>
           <div class='row'>
             <div class='col-md-6'>
                <p class='h2' style='font-family: calibri;'><a href='#' class='btn btn-success text-white'>Annulez la réinitialisation</a></p>
             </div>
             <div class='col-md-6'>
                <p class='h2' style='font-family: calibri;'><a href='' class='btn btn-danger text-white' onclick='return confirm('Cette action est irreversible')'>Confirmer la réinitialisation</a></p>
             </div>
           </div>
         </td>
         <tr>
           <td class='h2' style='font-family: calibri;padding: 15px 0;'><b>Si vous avez une question ou proposition, vous pouvez juste nous ecrire a info@cnsplateforme.com et on vous repondra a tout moment.</b> </td></tr>
                   
                     <tr>
                       <td class='h2' style='font-family: calibri;'>
                           <p>Pour plus de details, visiter <a href='http://cnsplateforme.com'>CNS Plateforme.com</a></p>
                       </td>
               </tr>
       </tr>
     </table>
   </td>
 </tr>
   
   " . self::emailLayoutSectionFooter();
    $Email = new \Email();
    return $Email->send($_Subject_, $_Message_, $_Email_, $firstname);
  }
  //send Email To Event User B2b On Reset Password


  // send Email To Participant On Buy Ticket
  public static function sendEmailToParticipantOnBuyTicket($_data_)
  {
    $_data_ = (object) $_data_;
    $email = $_data_->email;
    $firstname = $_data_->firstname;
    $event_name = $_data_->event_name;
    $tecket_type = $_data_->tecket_type;

    $_Email_ = $email;
    $_Subject_ = 'RESERVATION BILLET -' . $event_name;
    $_Message_ = self::emailSectionHeaderLayout() . "
    <tr>
      <td class='innerpadding borderbottom'>
        <table width='100%' border='0' cellspacing='0' cellpadding='0'>
          <tr>
          <td class='h2' style='font-family: calibri; padding: 15px 0px 30px 0px; '>Salut!, Cher <b>$firstname</b>,</td>
          </tr>
          <tr>
          <tr>
            <tr>
              <td class='h2' style='font-family: calibri;'>Merci d'avoir réservé un billet ($tecket_type) pour participer à l'événement <b> $event_name
              </b>  qui aura lieu à Goma, Le volcan / centre-ville; Le 29 Octobre 2022 à 15h - X Temps
            </tr>
            <tr>
              <td class='h2' style='font-family: calibri;padding: 15px 0;'><b>Recevoir le ticket ci-dessous</b> </td></tr>
                        <tr><td class='h2' style='font-family: calibri;'>Le jour de l'evenement presentez-vous avec votre ticket en pdf ou imprimer, qui vous permetra de participer a notre festival. <b><a href='' style='text-decoration: none'>Telecharger le billet ici</b></a></td></tr>
                        <tr><td class='h2' style='font-family: calibri;padding:0;'><b>Merci, nous avons hâte de vous voir à ce grand rendez-vous de la ville de goma</b> </td></tr>
                        <tr>
                          <td class='h2' style='font-family: calibri;'>
                             <p>Pour plus de details visiter <a href='http://event.cnsplateforme.com//ornyxland'>Ornyxland Festival</a></p>
                          </td>
                  </tr>
          </tr>
        </table>
      </td>
    </tr>
    " . self::emailLayoutSectionFooter();
    $Email = new \Email();
    return $Email->send($_Subject_, $_Message_, $_Email_, $firstname);
  }
  // send EmailTo Participant On Buy Ticket


  // send Email To Participant On Sending email
  public static function sendEmailToParticipantOnInvitationLink($_data_)
  {
    $_data_ = (object) $_data_;
    $email = $_data_->email;
    $participant_name = $_data_->participant_name;
    $event_name = $_data_->event_name;
    $event_type = $_data_->event_type;
    $organisation_name = $_data_->organisation_name;
    $ticket_type = $_data_->ticket_type;

    $_Email_ = $email;
    $_Subject_ = 'Invitation On' . $event_name . 'Event';
    $_Message_ = self::emailSectionHeaderLayout() . "
    <tr>
      <td class='innerpadding borderbottom'>
        <table width='100%' border='0' cellspacing='0' cellpadding='0'>
          <tr>
          <td class='h2' style='font-family: calibri; padding: 15px 0px 30px 0px; '>Salut!, Cher <b>$participant_name</b>,</td>
          </tr>
          <tr>
          <tr>
            <tr>
              <td class='h2' style='font-family: calibri;'> $organisation_name vous invite à prendre part à leur <b>$event_type , </b> en tant qu'invité(e) $ticket_type
                qui aura lieu à Goma, Le volcan / centre-ville; Le 29 Octobre 2022 à 15h - X Temps
            </tr>
            <tr>
              <td class='h2' style='font-family: calibri;padding: 15px 0;'><b>Repondre à l'invitation ci-desous</b> <i class='fa fa-laugh'></i> </td></tr>
                  <td class=''>
                     <p class='h2' style='font-family: calibri;'><a href='#' class='btn btn-success text-white'>Repondre</a></p>
                  </td>
                        <tr><td class='h2' style='font-family: calibri;padding:0;'><b>Merci, nous avons hâte de vous voir à ce grand rendez-vous de la ville de goma</b> </td></tr>
                        <tr>
                          <td class='h2' style='font-family: calibri;'>
                             <p>Pour plus de details visiter <a href='http://event.cnsplateforme.com//ornyxland'>Ornyxland Festival</a></p>
                          </td>
                  </tr>
          </tr>
        </table>
      </td>
    </tr>
    " . self::emailLayoutSectionFooter();
    $Email = new \Email();
    return $Email->send($_Subject_, $_Message_, $_Email_, $participant_name);
  }
  // send EmailTo Participant On Buy Ticket


  // sendEmailToParticipantOnSubmitApplication
  public static function sendEmailToParticipantOnSubmitApplication($_data_)
  {
    $_data_ = (object) $_data_;
    $email = $_data_->email;
    $firstname = $_data_->firstname;
    $event_name = $_data_->event_name;

    $_Email_ = $email;
    $_Subject_ = 'Confirmation - RIBA ANNUAL INSURANCE  CONFERENCE 2022 Registration';
    $_Message_ = self::emailSectionHeaderLayout() . "
      <tr>
        <td class='innerpadding borderbottom'>
          <table width='100%' border='0' cellspacing='0' cellpadding='0'>
            <tr>
            <td class='h2' style='font-family: calibri; padding: 15px 0px 30px 0px; '>Dear <b>$firstname</b>,</td>
            </tr>
            <tr>
            <tr>
              <tr>
                <td class='h2' style='font-family: calibri;'>Thank you for registering to attend the <b>RIBA ANNUAL INSURANCE  CONFERENCE 2022
                </b>  that will be held in  Rwanda, GISENYI, SERENA RESORT HOTEL; Wednesday 31 August- Saturday 3rd September 2022 
              </tr>
              <tr>
                <td class='h2' style='font-family: calibri;padding: 15px 0;'><b>Badge collection</b> </td></tr>
                          <tr><td class='h2' style='font-family: calibri;'>You will receive information on how and when to collect your badge before the event. We kindly require that you bring the identification document you used in your registration process when collecting your badge. </td></tr>
                          <tr><td class='h2' style='font-family: calibri;padding:0;'><b>Programme </b> </td></tr>
                          <tr>
                            <td class='h2' style='font-family: calibri;'>
                                <ul>
                                  <li>You can view the Riba programme at <a href='https://riba.rw/#program'>riba/programme</a></li>
                                </ul>
                            </td>
                    </tr>
            </tr>
          </table>
        </td>
      </tr>
      " . self::emailLayoutSectionFooter();
    $Email = new \Email();
    return $Email->send($_Subject_, $_Message_, $_Email_, $firstname);
  }



  /** - 10 - Send Email - Participant - Email received after successful registration for those that do not pay (Speakers, Invited guests, Secratariat, Staff etc) - On Approval  */
  public static function sendEmailToParticipantOnApproved($_data_)
  {
    $_data_ = (object) $_data_;
    $email = $_data_->email;
    $firstname = $_data_->firstname;

    $_Email_ = $email;
    $_Subject_ = 'Confirmation - RIBA ANNUAL INSURANCE CONFERENCE 2022 Registration';
    $_Message_ = self::emailSectionHeaderLayout() . "
                  <tr>
                    <td class='innerpadding borderbottom'>
                      <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                        <tr>
                        <td class='h2' style='font-family: calibri; padding: 15px 0px 30px 0px; '>Dear <b>$firstname</b>,</td>
                        </tr>
                        <tr>
                        <tr>
                          <td class='h2' style='font-family: calibri;'>Thank you for registering to attend the <b>RIBA ANNUAL INSURANCE  CONFERENCE 2022
                          </b>  that will be held in  Rwanda, GISENYI, SERENA RESORT HOTEL; Wednesday 31 August- Saturday 3rd September 2022 
                        </tr>
                        <tr><td class='h2' style='font-family: calibri;'>We have approved your registration. </td></tr>
                         
                        <tr><td class='h2' style='font-family: calibri;padding: 15px 0;'><b>Badge collection</b> </td></tr>
                        <tr><td class='h2' style='font-family: calibri;'>You will receive information on how and when to collect your badge before the event. We kindly require that you bring the identification document you used in your registration process when collecting your badge. </td></tr>
                        <tr><td class='h2' style='font-family: calibri;padding:0;'><b>Programme </b> </td></tr>
                        <tr>
                            <td class='h2' style='font-family: calibri;'>
                                <ul>
                                 <li>You can view the Riba programme at <a href='https://riba.rw/#program'>riba/programme</a></li>
                                </ul>
                            </td>
                         </tr>
                        </tr>
                      </table>
                    </td>
                  </tr>

      " . self::emailLayoutSectionFooter();
    $Email = new \Email();
    return $Email->send($_Subject_, $_Message_, $_Email_, $firstname);
  }


  /** - 10 - Send Email - Participant - Email received after successful registration for those that do not pay (Speakers, Invited guests, Secratariat, Staff etc) - On Approval  */
  public static function sendEmailToParticipantOnRejected($_data_)
  {
    $_data_ = (object) $_data_;
    $email = $_data_->email;
    $firstname = $_data_->firstname;

    $_Email_ = $email;
    $_Subject_ = 'Confirmation - RIBA ANNUAL INSURANCE CONFERENCE 2022 Registration';
    $_Message_ = self::emailSectionHeaderLayout() . "
                  <tr>
                    <td class='innerpadding borderbottom'>
                      <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                        <tr>
                        <td class='h2' style='font-family: calibri; padding: 15px 0px 30px 0px; '>Dear <b>$firstname</b>,</td>
                        </tr>
                        <tr>
                        <tr>
                          <td class='h2' style='font-family: calibri;'>Thank you for registering to attend the <b>RIBA ANNUAL INSURANCE  CONFERENCE 2022
                          </b>  that will be held in  Rwanda, GISENYI, SERENA RESORT HOTEL; Wednesday 31 August- Saturday 3rd September 2022 
                        </tr>
                        <tr><td class='h2' style='font-family: calibri;'>We have rejected your registration. </td></tr>
                        </tr>
                      </table>
                    </td>
                  </tr>

      " . self::emailLayoutSectionFooter();
    $Email = new \Email();
    return $Email->send($_Subject_, $_Message_, $_Email_, $firstname);
  }

  public static function sendOTPCode($_data_)
  {
    $_data_ = (object) $_data_;
    $email = $_data_->email;
    $firstname = $_data_->firstname;
    $otp = $_data_->otp;

    $_Email_ = $email;
    $_Subject_ = 'OTP Code - RIBA ANNUAL INSURANCE CONFERENCE 2022';
    $_Message_ = self::emailSectionHeaderLayout() . "
                  <tr>
                    <td class='innerpadding borderbottom'>
                      <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                        <tr>
                        <td class='h2' style='font-family: calibri; padding: 15px 0px 30px 0px; '>Dear <b>$firstname</b>,</td>
                        </tr>
                        <tr>
                        <tr>
                          <td class='h2' style='font-family: calibri;'>
                          This is your One Time Password(OTP). It will exipire after 30min. <strong> $otp </strong>
                          </td>
                        </tr>
                        </tr>
                      </table>
                    </td>
                  </tr>

      " . self::emailLayoutSectionFooter();
    $Email = new \Email();
    return $Email->send($_Subject_, $_Message_, $_Email_, $firstname, false);
  }



  /** - 10 - Send Email - Participant - On Approval  */
  public static function sendEmailToParticipantWelcomeWithProgram($_data_)
  {
    $_data_ = (object) $_data_;
    $email = $_data_->email;
    $firstname = $_data_->firstname;

    $_Email_ = $email;
    $_Subject_ = 'Last Updates - RIBA ANNUAL INSURANCE CONFERENCE 2022';
    $_Message_ = self::emailSectionHeaderLayout() . "
                  <tr>
                    <td class='innerpadding borderbottom'>
                      <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                        <tr>
                        <td class='h2' style='font-family: calibri; padding: 15px 0px 30px 0px; '>Dear <b>$firstname</b>,</td>
                        </tr>
                        <tr>
                        <tr>
                          <td class='h2' style='font-family: calibri;'>
                          I hope that this email finds you well and safe!
                          Kindly find below our latest updates on the 1ST RIBA ANNUAL INSURANCE CONFERENCE 2022.
                          </b>  
                          that will be held in  Rwanda, GISENYI, SERENA RESORT HOTEL; Wednesday 31 August- Saturday 3rd September 2022 
                        </tr>
                        <tr><td class='h2' style='font-family: calibri;'>We have rejected your registration. </td></tr>
                        </tr>
                      </table>
                    </td>
                  </tr>

      " . self::emailLayoutSectionFooter();
    $Email = new \Email();
    echo $_Message_;
    // return $Email->send($_Subject_, $_Message_, $_Email_, $firstname, false);
  }

  /* ++++++++++  SENDING EMAILS ON CNS EVENT PLATFORM END  +++++++++++ */




















  public static function emailSectionHeaderLayout()
  {
    $_HeaderLayout_ = "
    <!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
    <html xmlns='http://www.w3.org/1999/xhtml'>
    <head>
      <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
      <title>Email </title>
      <link rel='stylesheet' type='text/css' href='//fonts.googleapis.com/css?family=Ubuntu' />
      <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css'>
      <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js'></script>
      <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js'></script>
      <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css'/>
      <style type='text/css'>
      body {margin: 0; padding: 0; min-width: 100%!important; font-family: calibri;}
      img {height: auto;}
      .content {width: 100%; max-width: 600px;border:1px solid #f2f2f2;}
      .header {padding: 15px 30px 15px 30px; border-top:10px solid #15387d;}
      .innerpadding {padding: 30px 30px 10px 30px;}
      .borderbottom { background-color:#f6f6f6;}
      .subhead {font-size: 15px; color: #ffffff; font-family: calibri; letter-spacing: 10px;}
      .h1 {color: #ffffff; font-family: calibri;}
      .h2, .bodycopy {color: #2c2a2a; font-family: calibri;}
      .h1 {font-size: 30px; line-height: 38px; font-weight: bold;}
      .h2 {padding: 0 0 15px 0; font-size: 14px; line-height: 24px;}
      .h3 {padding: 0 0 5px 0; font-size: 14px; line-height: 28px; text-transform:uppercase}
      .bodycopy {font-size: 14px; line-height: 22px;}
      .button {text-align: center; font-size: 18px; font-family: calibri; font-weight: bold; padding: 0 30px 0 30px;}
      .button a {color: #ffffff; text-decoration: none;}
      .footer {padding: 10px 30px 10px 30px; border-bottom:10px solid #15387d; background: #fff;}
      .footer td a {color: #2a98c7; text-decoration:none}
      .footercopy {font-family: calibri; font-size: 14px; color: #ffffff;}
      .footercopy a {color: #ffffff; text-decoration: none;}
      ul{margin:0;}
      a {color: #2a98c7 !important;}
      td .list li strong {color: black !important; font-weight: 400; }
      .alignment{display: inline-block;background: #15387d;width: 100px;height: 2px;-webkit-border-radius: 2px;-moz-border-radius: 2px;border-radius: 2px;margin-bottom: 4px;}

      @media only screen and (max-width: 550px), screen and (max-device-width: 550px) {
      body[yahoo] .hide {display: none!important;}
      body[yahoo] .buttonwrapper {background-color: transparent!important;}
      body[yahoo] .button {padding: 0px!important;}
      body[yahoo] .button a {background-color: #f47e20; padding: 15px 15px 13px!important;}

     }
      </style>
    </head>

    <body yahoo bgcolor='#fff'>
    
      <table width='100%' bgcolor='#fff' border='0' cellpadding='0' cellspacing='0'>
        <tr>
          <td>
            <table bgcolor='#ffffff' class='content' align='center' cellpadding='0' cellspacing='0' border='0'>
              <tr>
                <td bgcolor='#fff' class='header'>
                  <table width='' align='left' border='0' cellpadding='0' cellspacing='0'>  
                    <tr>
                      <td>
                        <img class='fix' src='http://cnsplateforme.com/images/cns-logo_new.png' alt='CNS-LOGO' width='120' height='60' border='0' alt='' />
                      </td>
                      <td>
                         <h4 style='color: #15387d'>CNS PLATEFORME Inc</h4>
                      </td>
                    </tr>
                  </table> 
                </td>
              </tr>
      ";
    return $_HeaderLayout_;
  }


  public static function emailLayoutSectionFooter()
  {
    $_FooterLayout_ = "
        <tr>
        <td class='footer' bgcolor='#fff'>
          <table width='100%' border='0' cellspacing='0' cellpadding='0'>
            <tr>
              <td>
                <table border='0' cellspacing='0' cellpadding='0'>
                  <td class='h2' style='font-family: calibri; padding: 10px 0;  color:#15387d;text-transform:uppercase;'><b>Get in touch with us</b></td>
                </table>
                <span class='alignment'></span>
                <table border='0' cellspacing='0' cellpadding='0'>
                  <tr><td class='h2' style='font-family: calibri; padding:0;'><b><i class='fa fa-facebook'></i> Facebook:</b> <a href='https://web.facebook.com/#' target='_blank'>@CNS-Plateforme</a></td></tr>
                  <tr><td class='h2' style='font-family: calibri; padding:0;'><b><i class='fa fa-twitter'></i> Twitter:</b> <a href='https://twitter.com/#' target='_blank'>@CNS-Plateforme</a></td></tr>
                  <tr><td class='h2' style='font-family: calibri; padding:0;'><b><i class='fa fa-instagram'></i> Instagram:</b> <a href='https://web.facebook.com/#' target='_blank'>@CNS-Plateforme</a></td></tr>
                  <tr><td class='h2' style='font-family: calibri; padding:0;'><b><i class='fa fa-linkedin'></i> LinkedIn:</b> <a href='https://web.facebook.com/#' target='_blank'>@CNS-Plateforme</a></td></tr>
                                    
                </table>
              </td>
            </tr>
          </table>
          <p class='h4' style='font-family: calibri; padding:0; text-align: center; margin-bottom: -5px; margin-top: 30px'><em><b>CNS Event is powered by </b><a target='_blank' href='http://cnsplateforme.com'>CNS Plateforme Inc</a></em></p>
        </td>
      </tr>
    </table>
    </td>
    </tr>
    </table>
    </body>
    </html>
    ";
    return $_FooterLayout_;
  }



}



?>