<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$route['default_controller'] = 'home';
$route['video-highlights'] = 'highlight';
$route['video-highlights/nations/(:any)/(:any)'] = 'highlight/nation_events/$2/$1';
$route['video-highlights/competitions/(:any)/(:any)/(:any)/(:any)'] = 'highlight/competition_events/$1/$4';
$route['video-highlights/team-highlights/(:any)'] = 'highlight/get_team_events_highlights/$1';
$route['video-highlights/teams/(:any)/(:any)/(:any)/(:any)'] = 'home/team_events/$1';
$route['video-highlights/submit_highlight'] = 'highlight/submit_highlight';
$route['video-highlights/team_events'] = 'highlight/team_events';
$route['video-highlights/nation_events'] = 'highlight/nation_events';
$route['video-highlights/sport_event'] = 'highlight/sport_event';
$route['video-highlights/competition_events'] = 'highlight/competition_events';
$route['video-highlights/team_events'] = 'highlight/team_events';
$route['livestreaming/(:any)'] = 'home/sport_event/$1';
$route['video-highlights/(:any)'] = 'highlight/sport_event/$1';
$route['watch/(:any)'] = 'home/get_myteam_event/$1';

$route['live-channels'] = 'home/get_live_channel_streaming/42';
$route['live-channels/(:any)'] = 'home/get_live_channel_streaming/$1';
$route['blog'] = 'home/menu/news-guide';

$route['nations/(:any)/(:any)'] = 'home/nation_events/$2/$1';
$route['competitions/(:any)/(:any)/(:any)/(:any)'] = 'home/competition_events/$1/$4';


$route['teams/(:any)/(:any)/(:any)/(:any)'] = 'home/team_events/$1';

$route['transaction'] = 'transaction/transaction_manager/index';
$route['transcation/deposit'] = 'transaction/transaction_manager/postDepositForm';

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
