import * as Init from '../../../../core/jscore/init.js';
import { EncryptionEzpk } from '../../../../core/jscore/classes/EncryptionEzpk.js';
import { Address } from '../../../../core/jscore/classes/Address.js';
import { IOSystem } from '../../../../core/jscore/classes/IOSystem.js';
let VWAddress = new Address();
let VWIOSystem = new IOSystem();
const hostname = Init.API_CLUSTER;


//number of notification
// if (VWIOSystem.exists('.smart-card')) {
//     let _id_ = $('#_id_').val();
//     getNotificationById(_id_);
//   }
  
  
  function getNotificationById(_id_ = 1) {
    var form_data = $('#filfterFormCountNotification').serialize();
  
    var row_card_items = '';
  
    $.ajax({
      url: hostname,
      type: "POST",
      headers: {
        'Authorization': Init._AUTH_
      },
      cache: false,
      data: form_data,
      success: function (dataResponse) {
     
        var response = JSON.parse(dataResponse);
        if (response.status == 200) {
          
          response.data = response;
      
          row_card_items = row_card_items + ` 
          <a class="btn btn-sm pmd-btn-fab pmd-btn-flat href="javascript:void(0);" id="navbarDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i data-badge="${response.data.count}" class="material-icons pmd-badge pmd-badge-overlap pmd-badge-success md-dark pmd-sm">
                notifications_none
            </i>
          </a>

          <div class="dropdown-menu dropdown-menu-right notifications-col" aria-labelledby="navbarDropdown">
				    <div class="card pmd-card mb-0">
					  <div class="card-header d-flex w-100 justify-content-between pmd-card-border">
						  <h3 class="pmd-list-title mb-0">Notifications</h3>
						  <a href="${Init.DN}admin/inbox/notifications" class="text-primary"><small> ${response.data.count} New Notifications</small></a>
            </div>
            <!-- 
					  <div class="list-group pmd-list pmd-list-border">
						
                        <a class="list-group-item d-flex flex-row" href="${Init.DN}admin/inbox/notifications">
                            <span class="pmd-avatar-list-img">
                                <img alt="Keel" data-src="holder.js/40x40" class="img-fluid" src="<?=DNADMIN?>/build/vendor/themes/images/profile-2.jpg" data-holder-rendered="true"> 
                            </span> 
                            <div class="media-body">
                                <h3 class="pmd-list-title">Today is <strong>Samuel Smith</strong>'s birthday.</h3>
                                <p class="pmd-list-subtitle">15 Minutes ago</p> 
                            </div>
                        </a>
					  </div> -->
				</div>
			</div>
          `;        
        }
        else {
        
          var response = JSON.parse(dataResponse);  
            response.data = response;
            row_card_items = row_card_items + ` 
            <a class="btn btn-sm pmd-btn-fab pmd-btn-flat href="javascript:void(0);" id="navbarDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i data-badge="0" class="material-icons pmd-badge pmd-badge-overlap pmd-badge-success md-dark pmd-sm">
                  notifications_none
              </i>
            </a>
            <div class="dropdown-menu dropdown-menu-right notifications-col" aria-labelledby="navbarDropdown">
				      <div class="card pmd-card mb-0">
					      <div class="card-header d-flex w-100 justify-content-between pmd-card-border">
						      <h3 class="pmd-list-title mb-0">Notifications</h3>
						      <a href="${Init.DN}admin/inbox/notifications" class="text-primary"><small> 0 Notification</small></a>
                </div>
              </div>
            </div>
          
            ` ;
  
        }
        $('.smart-card').html(row_card_items);
      }
    });
  }
  

