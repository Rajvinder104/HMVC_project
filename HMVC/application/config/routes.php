<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
// $route['default_controller'] = 'Web/welcome';
// $route['default_controller'] = 'site/controller/';
// $route['Dashboard/Homecontroller/insert_data'] = 'Dashboard/Homecontroller/add_data';
// $route['Dashboard/Homecontroller/display_data'] = 'Dashboard/Homecontroller/fetch_data';
// $route['404_override'] = '';
// $route['translate_uri_dashes'] = True;
// $route['register'] = 'User/Register/index';
// $route['login'] = 'User/login';
// $route['activation'] = 'User/Activation';
// $route['dashboard'] = 'User/Index';

$route['default_controller'] = 'Admin/Management/login';
$route['AdminSecure_Area'] = 'Admin/Management/login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

//**==================================== Dashboard Apis ====================================**//
//** Dashboard Auth */
$route['Mainlogin'] = 'Dashboard/Auth/login';
$route['login'] = 'Dashboard/Auth/signin';
$route['logout'] = 'Dashboard/Auth/signout';
$route['dashboard/reset-password'] = 'Dashboard/Auth/passwordReset';
$route['dashboard/forget-password'] = 'Dashboard/Auth/forgetPassword';

//** Dashboard Register */
if (registration == 0) {
    $route['dashboard/activate'] = 'Dashboard/Activation/activate';
    $route['register']['GET'] = 'Dashboard/Register/simpleRegister';
    $route['register']['POST'] = 'Dashboard/Register/simpleRegister';
    $route['upgradeAjax'] = 'Dashboard/Activation/upgradeBinary';
    $route['activateAjax2'] = 'Dashboard/Activation/Reinvestment';
} elseif (registration == 1) {
    $route['activateAjax'] = 'Dashboard/Activation/activateBinary';
    $route['register']['GET'] = 'Dashboard/Register/binaryRegister';
    $route['register']['POST'] = 'Dashboard/Register/binaryRegister';
    $route['upgradeAjax'] = 'Dashboard/Activation/upgradeBinary';
    $route['dashboard/reinvest'] = 'Dashboard/Activation/Reinvestment';

}
$route['dashboard/reinvest'] = 'Dashboard/Activation/Reinvestment';

$route['dashboard/myactivate'] = 'Dashboard/Activation/myactivateview';

//** Dashboard UserInfo  */
$route['dashboard'] = 'Dashboard/UserInfo/index';
$route['dashboard/directs/(.+)'] = 'Dashboard/UserInfo/directs/$1';
$route['dashboard/myDownline/(.+)'] = 'Dashboard/UserInfo/myDownline/$1';
$route['dashboard/tree/(:any)'] = 'Dashboard/UserInfo/Tree/$1';
$route['dashboard/genelogy-tree/(:any)'] = 'Dashboard/UserInfo/GenelogyTree/$1';
$route['dashboard/pool/(:any)'] = 'Dashboard/UserInfo/Pool/$1';
$route['get_user/(.+)'] = 'Dashboard/UserInfo/get_user/$1';
$route['dashboard/my-team'] = 'Dashboard/UserInfo/myTeam';
$route['dashboard/my-team/(:num)'] = 'Dashboard/UserInfo/myTeam';
$route['dashboard/success'] = 'Dashboard/UserInfo/success';

//** Dashboard Transfer  */
$route['dashboard/income-transfer'] = 'Dashboard/Transfer/IncomeTransfer';
$route['dashboard/income_wallet-transfer'] = 'Dashboard/Transfer/incomeToeWalletTransfer';
$route['dashboard/wallet-transfer'] = 'Dashboard/Transfer/eWalletTransfer';

//** Dashboard Profile */
$route['dashboard/profile'] = 'Dashboard/Profile/index';
$route['dashboard/account-details'] = 'Dashboard/Profile/accountDetails';
$route['dashboard/upload-proof'] = 'Dashboard/Profile/UploadProof';
$route['dashboard/transaction-password'] = 'Dashboard/Profile/transPassword';
$route['dashboard/zil-update'] = 'Dashboard/Profile/zilUpdate';
$route['dashboard/I_Card'] = 'Dashboard/UserInfo/I_Card';
$route['dashboard/welcomeLetter'] = 'Dashboard/UserInfo/welcomeLetter';
$route['dashboard/reinvest'] = 'Dashboard/Activation/reinvest';


//** Dashboard Support  */
$route['dashboard/compose-mail'] = 'Dashboard/Support/ComposeMail';
$route['dashboard/inbox-mail'] = 'Dashboard/Support/Inbox';
$route['dashboard/outbox-mail'] = 'Dashboard/Support/Outbox';

//** Dashboard Fund  */
if (fund_process == 0) {
    $route['dashboard/fund-request'] = 'Dashboard/Fund/Request_fund';
} elseif (fund_process == 1) {
    $route['dashboard/fund-request'] = 'Dashboard/Fund/Deposit_fund';
}
$route['dashboard/fund-history'] = 'Dashboard/Fund/fundHistory';
$route['dashboard/fund-history/(:num)'] = 'Dashboard/Fund/fundHistory';
$route['dashboard/fundrequest-history'] = 'Dashboard/Fund/fundRequestHistory';
$route['dashboard/fundrequest-history/(:num)'] = 'Dashboard/Fund/fundRequestHistory';

//** Dashboard Activation  */
$route['dashboard/activate-account'] = 'Dashboard/Activation/index';
$route['dashboard/updgrade-account'] = 'Dashboard/Activation/UpgradeAccount';
$route['dashboard/activate-history'] = 'Dashboard/Activation/accountHistory';
$route['dashboard/activate-history/(:num)'] = 'Dashboard/Activation/accountHistory';

//** Dashboard Withdraw  */
if (withdraw == 0) {
    $route['dashboard/directIncomeWithdraw'] = 'Dashboard/Withdraw/DirectIncomeWithdraw_Bank';
    $route['dashboard/directWithdraw'] = 'Dashboard/Withdraw/DirectWithdraw_Bank';

} else {
    $route['dashboard/directIncomeWithdraw'] = 'Dashboard/Withdraw/DirectIncomeWithdraw_Wallet';
}
$route['dashboard/withdraw-history'] = 'Dashboard/Withdraw/withdrawHistory';
$route['dashboard/withdraw-history/(:num)'] = 'Dashboard/Withdraw/withdrawHistory';

//** Dashboard Incomes */
$route['dashboard/payout-summary'] = 'Dashboard/Incomes/payout_summary';
$route['dashboard/payout-summary/(:num)'] = 'Dashboard/Incomes/payout_summary';
$route['dashboard/datewise-payout/(.+)'] = 'Dashboard/Incomes/dateWisePayout/$1';
$route['dashboard/incomes/(.+)'] = 'Dashboard/Incomes/incomes/$1';
$route['dashboard/income-ledger'] = 'Dashboard/Incomes/incomesLedger';
$route['dashboard/income-ledger/(:num)'] = 'Dashboard/Incomes/incomesLedger';

//**==================================== Sub Admin Apis ====================================**//

$route['admin/permissions'] = 'Admin/Permissions/index';
$route['admin/permissions/(:num)'] = 'Admin/Permissions/index';
$route['admin/create-subadmin'] = 'Admin/Permissions/CreateSubAdmin';
$route['admin/change-permissions/(.+)']['GET'] = 'Admin/Permissions/ChangePermissions/$1';
$route['admin/change-permissions/(.+)']['POST'] = 'Admin/Permissions/ChangePermissions/$1';
$route['admin/edit-subadmin/(.+)']['GET'] = 'Admin/Permissions/edit/$1';
$route['admin/edit-subadmin/(.+)']['POST'] = 'Admin/Permissions/edit/$1';
$route['admin/access-deined'] = 'Admin/Permissions/accessDeined';
$route['admin/sub-login'] = 'Admin/Management/Sublogin';


//**==================================== Admin Apis ====================================**//
//** Admin Auth */

$route['admin/login'] = 'Admin/Management/login';
$route['admin/logout'] = 'Admin/Management/logout';
//** Admin Management */

$route['admin/dashboard'] = 'Admin/Management/index';
$route['admin/edit-user/(.+)'] = 'Admin/Management/EditUser/$1';
//** Admin Reports */
$route['admin/users'] = 'Admin/Management/users';
$route['admin/users/(:any)'] = 'Admin/Management/users';
$route['admin/todayJoined'] = 'Admin/Management/todayJoinedusers';
$route['admin/todayJoined/(:any)'] = 'Admin/Management/todayJoinedusers';
$route['admin/user-login/(.+)'] = 'Admin/Management/user_login/$1';
$route['admin/edit-user/(.+)'] = 'Admin/Settings/EditUser/$1';
$route['admin/paid-users'] = 'Admin/Management/paidUsers';
$route['admin/paid-users/(:any)'] = 'Admin/Management/paidUsers';
$route['admin/availableIncome'] = 'Admin/Report/availableIncome';
$route['admin/availableIncome/(:any)'] = 'Admin/Report/availableIncome';
$route['admin/todaypaid-users'] = 'Admin/Management/TodaypaidUsers';
$route['admin/todaypaid-users/(:any)'] = 'Admin/Management/TodaypaidUsers';
$route['admin/sendIncome'] = 'Admin/Management/sendIncome';
$route['admin/buy-price'] = 'Admin/Settings/token_value';
$route['admin/sell-value'] = 'Admin/Settings/sellValue';
$route['admin/news'] = 'Admin/Settings/news';
$route['admin/create-news'] = 'Admin/Settings/CreateNews';
$route['admin/reset-password'] = 'Admin/Settings/passwordReset';
$route['admin/edit-news/(.+)'] = 'Admin/Settings/editNews/$1';
$route['admin/delete-news/(.+)'] = 'Admin/Settings/deleteNews/$1';
$route['admin/popup'] = 'Admin/Settings/popup_upload';
$route['admin/qrcode'] = 'Admin/Settings/upload_qrcode';
$route['admin/incomes/(.+)'] = 'Admin/Withdraw/income/$1';
$route['admin/today-income/(.+)'] = 'Admin/Withdraw/today_income/$1';
$route['admin/income-ledgar'] = 'Admin/Withdraw/incomeLedgar';
$route['admin/income-ledgar/(:any)'] = 'Admin/Withdraw/incomeLedgar';
$route['admin/payout-summary'] = 'Admin/Withdraw/payout_summary';
$route['admin/payout-summary/(:num)'] = 'Admin/Withdraw/payout_summary';
$route['admin/dateWisePayout/(.+)'] = 'Admin/Withdraw/dateWisePayout/$1';
$route['admin/kyc-history/(.+)'] = 'Admin/Withdraw/AddressRequests/$1';
$route['admin/withdraw-history/(.+)'] = 'Admin/Withdraw/WithdrawHistory/$1';
$route['admin/inbox'] = 'Admin/Support/inbox';
$route['admin/inbox/(.+)'] = 'Admin/Support/inbox';
$route['admin/outbox'] = 'Admin/Support/outbox';
$route['admin/outbox/(.+)'] = 'Admin/Support/outbox/$1';
$route['admin/compose'] = 'Admin/Support/compose';
$route['admin/compose/(:num)'] = 'Admin/Support/compose';
$route['admin/compose-mail'] = 'Admin/Support/ComposeMail';
$route['admin/Add-image'] = 'Admin/Settings/Add_image';
// $route['admin/Achiever-report'] = 'Admin/Settings/Achiever_report';
$route['admin/Achiever-report'] = 'Admin/Report/Achiever_report';

$route['admin/support-view/(.+)']['GET'] = 'Admin/Support/view/$1';
$route['admin/support-view/(.+)']['POST'] = 'Admin/Support/view/$1';

//** Admin Withdraw */
$route['admin/withdraw-request/(.+)'] = 'Admin/Withdraw/request/$1';
$route['admin/send-wallet'] = 'Admin/Management/SendWallet';
$route['admin/fund-history'] = 'Admin/Management/fund_history';
$route['admin/fund-history/(:num)'] = 'Admin/Management/fund_history';
$route['admin/adminfund-history'] = 'Admin/Management/admin_fund_history';
$route['admin/adminfund-history/(:num)'] = 'Admin/Management/admin_fund_history';
$route['admin/send-coin'] = 'Admin/Management/SendCoin';
$route['admin/set-withdraw-timing'] = 'Admin/Withdraw/Setwithdrawtiming';

//** Admin Fund */
$route['admin/fund-requests/(.+)'] = 'Admin/Management/Fund_requests/$1';
$route['admin/update-fund-request/(.+)'] = 'Admin/Management/update_fund_request/$1';
//** Admin Settings */
$route['admin/create-news'] = 'Admin/Settings/CreateNews';
$route['admin/news-history'] = 'Admin/Settings/newsHistory';
$route['admin/edit-news/(.+)'] = 'Admin/Settings/EditNews/$1';
$route['admin/delete-news/(.+)'] = 'Admin/Settings/DeleteNews/$1';
$route['admin/token-value'] = 'Admin/Settings/tokenValue';
$route['admin/sethub-rate'] = 'Admin/Settings/setHubRate';

$route['admin/incomes'] = 'Admin/Withdraw/incomes';
$route['admin/incomes/(.+)'] = 'Admin/Withdraw/incomes/$1';


// my routes
$route['dashboard/walletincome'] = 'Dashboard/Reports/walletincome';
$route['dashboard/walletincome/(:num)'] = 'Dashboard/Reports/walletincome';
$route['dashboard/wallettable'] = 'Dashboard/Reports/wallettable';
$route['dashboard/wallettable/(:num)'] = 'Dashboard/Reports/wallettable';
$route['dashboard/incomewallet'] = 'Dashboard/Reports/incomewallet';
$route['dashboard/incomewallet/(:num)'] = 'Dashboard/Reports/incomewallet';

// all pagination example in below
$route['dashboard/grouplevel'] = 'Dashboard/Reports/grouplevel';
$route['dashboard/grouplevel/(:num)'] = 'Dashboard/Reports/grouplevel/$1';
 $route['dashboard/records/(.+)'] = 'Dashboard/Reports/records/$1';
// all pagination END example in below

//$route['dashboard/records/(:num)'] = 'Dashboard/Reports/records/$1';





$route['admin/walletincome'] = 'Admin/Report/walletincome';
$route['admin/walletincome/(:num)'] = 'Admin/Report/walletincome';
$route['admin/wallettable'] = 'Admin/Report/wallettable';
$route['admin/wallettable/(:num)'] = 'Admin/Report/wallettable';
$route['admin/incomewallet'] = 'Admin/Report/incomewallet';
$route['admin/incomewallet/(:num)'] = 'Admin/Report/incomewallet';

// $route['admin/incomes-all'] = 'Admin/Report/incomes';
// $route['admin/incomes-all/(:num)'] = 'Admin/Report/incomes';

// $route['admin/incomes_all/(.+)'] = 'Admin/Report/incomes_all/$1';

$route['admin/incomes_all/(.+)'] = 'Admin/Report/incomes_all/$1';


$route['admin/payout_summarys'] = 'Admin/Report/payout_summarys';
$route['admin/payout_summarys/(:num)'] = 'Admin/Report/payout_summarys';

// $route['admin/dateWisePayouts/'] = 'Admin/Report/dateWisePayouts';
$route['admin/dateWisePayouts/(.+)'] = 'Admin/Report/dateWisePayouts/$1';
$route['admin/dateWise/(.+)'] = 'Admin/Report/dateWise/$1';
$route['admin/date_weeks'] = 'Admin/Report/date_weeks';
$route['admin/date_weeks/(:num)'] = 'Admin/Report/date_weeks';




$route['admin/levels'] = 'Admin/Report/levels';
$route['admin/levels/(:num)'] = 'Admin/Report/levels/$1';
$route['admin/groupbylevelz/(.+)'] = 'Admin/Report/groupbylevelz/$1';

$route['admin/groupsusers'] = 'Admin/Report/groupsusers';
$route['admin/groupsusers/(:num)'] = 'Admin/Report/groupsusers/$1';
$route['admin/groupuser/(.+)'] = 'Admin/Report/groupuser/$1';

$route['dashboard/levels'] = 'Dashboard/Reports/levels';
$route['dashboard/levels/(:num)'] = 'Dashboard/Reports/levels';
$route['dashboard/groupbylevelz/(.+)'] = 'Dashboard/Reports/groupbylevelz/$1';

$route['dashboard/Team'] = 'Dashboard/Reports/Team';
$route['admin/generate_report'] = 'Admin/Report/generate_report';

$route['admin/Addimage'] = 'Admin/Settings/Addimage';

$route['admin/Activation-details'] = 'Admin/Report/Activationdetails';
$route['admin/package-history'] = 'Admin/Report/packageHistory';
$route['admin/package-history/(:num)'] = 'Admin/Report/packageHistory';


$route['admin/myfunction'] = 'Admin/Report/myfunction';
$route['admin/myfunction/(:num)'] = 'Admin/Report/myfunction';
$route['admin/imgdata'] = 'Admin/Report/imgdata';

$route['dashboard/uploaddocument'] = 'Dashboard/Profile/uploaddocument';
$route['dashboard/uploaddocument/(:num)'] = 'Dashboard/Profile/uploaddocument/$1';

// $route['admin/kyc-history/(.+)'] = 'Admin/Withdraw/AddressRequests/$1';
$route['admin/uploaddocument/(.+)'] = 'Admin/Settings/uploaddocument/$1';

//$route['admin/kycdetails'] = 'Admin/Report/kycdetails';
$route['admin/kycdetails'] = 'Admin/Report/kycdetails';
$route['admin/uploadimg'] = 'Admin/Settings/uploadimg';


$route['dashboard/Sendmail'] = 'Dashboard/Support/Sendmail';
$route['dashboard/inboxreport'] = 'Dashboard/Support/inboxreport';
$route['dashboard/outboxreport'] = 'Dashboard/Support/outboxreport';
$route['admin/inbx'] = 'Admin/Support/inbx';
$route['admin/outbx'] = 'Admin/Support/outbx';
$route['admin/viewbtn/(.+)'] = 'Admin/Support/viewbtn/$1';




