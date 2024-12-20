<link rel="stylesheet" href="{$tplVar['rootURL']}/modules/addons/pay_to_address/assets/css/style.css">  
<script src="{$tplVar['rootURL']}/modules/addons/pay_to_address/assets/js/payaddressjs.js"></script>

{* <pre> *}
{* {$tplVar['rootURL']|print_r} *}
{* </pre> *}


<div class="container-fluid">
  <a href="">
    <div class="menu_bar ticket-tag-menu">
      <img src="{$tplVar['rootURL']}/modules/addons/pay_to_address/assets/images/whmcs-logo.svg">      
      <ul>
        <li class="active">
          <a href="#">
            <span class="glyphicon glyphicon-cog"></span>
            Setting
          </a>
        </li>
      </ul>
    </div>  
  </a>
</div>


{if $tplVar['error']}
    <div class="errorbox"><strong><span class="title">Error</span></strong><br>{$tplVar['error']}</div>
{/if}
{if $tplVar['success']}
    <div class="successbox"><strong><span class="title">Success</span></strong><br>{$tplVar['success']}</div>
{/if}

{if $tplVar['deletepool']}
  <div class="alert alert-success" role="alert">
      Deleted Successfully.
  </div>
{/if}
{* <div class="modal-header"> *}

{* <button type="button" class="close" data-dismiss="modal" fdprocessedid="p9p4ie">×</button> *}
{* </div> *}
<div class="container">
  <div class="col-sm-12 auto-m d-block">
    <div class="box ticket-tag-box">
      <form action="" method="post">
        {* <input type="hidden" name="token" value="15a63b2b6d28ab659d35c83d09f3b410835448a4"> *}
        
        <div class="form-group">
          <label for="select_currency">Select Currency</label>
          <select name="select_currency" id="select_currencyUpdate" class="form-control">
            <option selected disabled>ANY</option>
            {foreach from=$tplVar['currencyCode'] item=item}
              <option value="{$item->id}" {if $item->id == $tplVar['exchangeCurrency']}selected{/if}>{$item->code}</option>
            {/foreach}
          </select>
        </div>
        <div class="form-group">
          <label for="pay_to_taxUpdate">Pay to Tax</label>
          <textarea id="pay_to_taxUpdate" class="form-control" name="pay_to_taxUpdate" rows="4" ></textarea>
            <span class="error" style="display:none">This field is required</span>
          {* <div class="invalid-feedback">Please enter a value for Pay to Tax.</div> *}
        </div>
        <input type="submit" class="btn btn-success" name="Save" id="add_pay_address"value="Submit" fdprocessedid="r0vfsd">
      </form> 
    </div>
  </div>
</div>
<table class="datatable" id="tblModuleLog" width="100%" border="0" style="text-align: center;" cellspacing="5"
cellpadding="5">


    <thead>
      <tr class="info">
        <th>CurrencyCode</th>
        <th>Pay To Address</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>


     {foreach $tplVar['currencyData'] as $currencyDetails}
      {* <pre> *}
      {* {$currencyDetails|print_r}s *}
      {* </pre> *}
            <tr class='text-center'>

                <td>{$currencyDetails->currency}</td>
               <td><textarea readonly style="width: 338px; height: 130px;"
                        class="form-control input" col="50" rows="5">{$currencyDetails->pay_to_address}</textarea></td>
               <td>
               <button type="button" class="btnClick btn btn-default btn-sm" data-toggle="modal" data-target="#myModal" data-currencyCode="{$currencyDetails->currency_code}" data-id="{$currencyDetails->id}" data-currency="{$currencyDetails->currency}" data-address="{$currencyDetails->pay_to_address}"><span class="glyphicon glyphicon-pencil"></span></button>
                            <a href="addonmodules.php?module=pay_to_address&action=dashboard&CurrencyId={$currencyDetails->id}"
                                onclick="return confirm('Are you sure you want to delete this?');">
                                <i class="fas fa-regular fa-trash delete"
                                    style="color:#d9534f;margin-left:5px;cursor:pointer"></i>
                            </a>
                           
                  </td>
                 
                
                
            </tr>
            {/foreach}
      
    </tbody>
  </table> 

  <div class="modal fade edit-popup" id="myModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit details   </h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    <div class="form-group">
                        <b><p class="text-success" id="msg"></p></b>
                        <label for="select_currency">Select Currency</label>
                        <select name="select_currency" id="select_currency" class="form-control">
                        <option selected disabled>ANY</option>
                            {foreach from=$tplVar['currencyCode'] item=item}

                              
                        <option value="{$item->id}" {if $item->id == $tplVar['currencyData']}selected{/if}>{$item->firstname}</option>
                            {/foreach}
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="pay_to_tax">Pay to Tax</label>
                        <textarea id="pay_to_tax" name="pay_to_tax" rows="4" class="form-control" required></textarea>
                          {* <span class="error">This field is required</span> *}
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="updateBtn" class="btn btn-success UpdateSub" name="update">Update</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- jQuery Initialization -->
<script>
    $(document).ready(function() {
        $('.datatable').DataTable();
    });
</script>
