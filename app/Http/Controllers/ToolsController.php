<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ToolsController extends Controller
{
    public function share_tkqc_to_via()
    {
        return view('tools.share_tkqc_to_via');
    }

    public function share_tkqc_to_via_api(Request $request)
    {
        $dataPost = $request->all();
        $acc = $dataPost['acc'];
        $proxy = $dataPost['proxy'];
        $cookie_invited = $dataPost['uid'];

        $info = $this->getInfo($cookie_invited);
        $targetUid = $info['uid'];
        $fb_dtsg = $info['fb_dtsg'];

        $cookie = $acc;
        $info1 = $this->getInfo($cookie);
        $uid = $info['uid'];
        $_fb_dtsg = $info['fb_dtsg'];
        $this->addFriend($cookie, $_fb_dtsg, $uid, $targetUid, $proxy);

        $this->acceptFriend($cookie_invited, $fb_dtsg, $uid, $targetUid, $proxy);

        $html = $this->postData('https://www.facebook.com/ads/manager/account_settings/information/', null, $cookie, $proxy);
        preg_match('/\{"adAccountID":"(.*?)"/', $html, $matches);
        $adsId =  $matches[1];

        $adsPage = $this->postData('https://www.facebook.com/adsmanager/manage/?act=' . $adsId . '&nav_source=no_referrer', null, $cookie, $proxy);
        preg_match('/window\.__accessToken="(.*?)"/', $adsPage, $matches);
        $token =  $matches[1];

        $url = 'https://graph.facebook.com/v10.0/act_' . $adsId . '/users?_reqName=adaccount%2Fusers&access_token=' . $token . '&method=post';

        $role = '461336843905730';

        $fields = [
            '_reqName' =>  'adaccount/users',
            '_reqSrc' =>  'AdsPermissionDialogController',
            '_sessionID' =>  '2545288d927d9175',
            'account_id' =>  $adsId,
            'include_headers' =>  'false',
            'locale' =>  'vi_VN',
            'method' =>  'post',
            'pretty' =>  '0',
            'role' =>  $role,
            'suppress_http_code' =>  1,
            'uid' =>  $targetUid,
            'xref' =>  'f210e70626565c'
        ];

        $result = json_decode($this->postData($url, http_build_query($fields), $cookie, $proxy), true);
        if ($result['success']) {
            echo json_encode([
                'status' => 'success'
            ]);
        } else {
            echo json_encode([
                'status' => 'fail'
            ]);
        }
    }

    protected function postData($url, $fields = null, $cookie = null, $proxy = null, $ua = 'desktop')
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if ($ua == 'mobile') {
            curl_setopt($ch, CURLOPT_USERAGENT, 'Opera/9.80 (Windows NT 6.0) Presto/2.12.388 Version/12.14');
        } else {
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.98 Safari/537.36');
        }
        if ($fields) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        }


        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        if ($cookie) {
            curl_setopt($ch, CURLOPT_COOKIE, $cookie);
        }
        if ($proxy) {
            curl_setopt($ch, CURLOPT_PROXY, $proxy);
        }
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    protected function getInfo($cookie, $proxy = null)
    {
        $fb_dtsg = $this->fb_dtsg($cookie, $proxy);
        return [
            'status' => 'success',
            'fb_dtsg' => $fb_dtsg['value'],
            'uid' => $fb_dtsg['uid'],
            'name' => $fb_dtsg['name'],
        ];
    }

    protected function fb_dtsg($cookie, $proxy = null)
    {
        $url = $this->postData("https://m.facebook.com/profile.php", null, $cookie, $proxy, 'mobile');
        preg_match('#name="fb_dtsg" value="(.+?)"#is', $url, $match1);
        preg_match('#name="target" value="(.+?)"#is', $url, $match2);
        preg_match('#<title>(.+?)</title>#is', $url, $match3);
        if (isset($match1[1])) {
            if (empty(trim($match2[1]))) {
                return false;
            }
            return [
                'status' => true,
                'value' => trim($match1[1]),
                'uid' => trim($match2[1]),
                'name' => trim($match3[1]),
            ];
        } else {
            $url = $this->postData("https://fb.com/", null, $cookie, $proxy);
            preg_match('#name="fb_dtsg" value="(.+?)"#is', $url, $match1);
            preg_match('#name="target" value="(.+?)"#is', $url, $match2);
            preg_match('#<title>(.+?)</title>#is', $url, $match3);
            if (isset($match1[1])) {
                if (empty(trim($match2[1]))) {
                    return false;
                }
                return [
                    'status' => true,
                    'value' => trim($match1[1]),
                    'uid' => trim($match2[1]),
                    'name' => trim($match3[1]),
                ];
            }
        }
        return false;
    }

    protected function addFriend($cookie, $fb_dtsg, $uid, $targetUid, $proxy)
    {
        $url = 'https://m.facebook.com/a/friends/profile/add/?subject_id=' . $targetUid . '&is_timeline=1&how_found=profile_button&ref_param=unknown&ext=1625072604&hash=AeRYiBunhdG7HpQfpe8&refid=17&__xts__[0]=48.%7B%22event%22%3A%22add_friend%22%2C%22intent_status%22%3Anull%2C%22intent_type%22%3Anull%2C%22profile_id%22%3A' . $targetUid . '%2C%22ref%22%3A3%7D';
        $data = [
            'fb_dtsg' => $fb_dtsg,
            'jazoest' => '22513',
            'lsd' => 'DQCXiUfcqYWlLeETOPAHaU',
            '__dyn' => '1KQEGiFo525Ujwh8-t0BBBgS5UqxKcwRwAxu3-UcodUbEdEc8uKew8i5orx64o720SUhwem0iy1gCwSxu0BU3JxO1ZxObwro7ifw5KzHzo5jwp84a1Pwk888C0NE2oCwSwaOfxW0D86i0DU985G0zE5W0HU420gO1AyES',
            '__csr' => '',
            '__req' => '7',
            '__a' => 'AYmgaP4bMguziPlRfj5LbF4DS6iYcFlVHlJYQr2E8SAxpozEqJ_-da2PS0wM2fIq_hCi9xD8bPj5DlUUx3ri-UlvHP7N3LT7o2iAnCHvxEhR_g',
            '__user' => $uid
        ];

        $this->postData($url, http_build_query($data), $cookie, $proxy);
    }

    protected function acceptFriend($cookie, $fb_dtsg, $uid, $targetUid, $proxy)
    {
        $url = 'https://m.facebook.com/a/mobile/friends/confirm/?subject_id=' . $targetUid . '&view_as_id=' . $uid . '&ref_param=m_find_friends&is_from_friending_list=1&friending_location=friend_center_requests&ext=1625072916&hash=AeSaeelhMaCjumeQZcY';
        $data = [
            'fb_dtsg' => $fb_dtsg,
            'jazoest' => '22513',
            'lsd' => 'DQCXiUfcqYWlLeETOPAHaU',
            '__dyn' => '1KQEGiFo525Ujwh8-t0BBBgS5UqxKcwRwAxu3-UcodUbEdEc8uKew8i5orx64o720SUhwem0iy1gCwSxu0BU3JxO1ZxObwro7ifw5KzHzo5jwp84a1Pwk888C0NE2oCwSwaOfxW0D86i0DU985G0zE5W0HU420gO1AyES',
            '__csr' => '',
            '__req' => '7',
            '__a' => 'AYmgaP4bMguziPlRfj5LbF4DS6iYcFlVHlJYQr2E8SAxpozEqJ_-da2PS0wM2fIq_hCi9xD8bPj5DlUUx3ri-UlvHP7N3LT7o2iAnCHvxEhR_g',
            '__user' => $uid
        ];

        $this->postData($url, http_build_query($data), $cookie, $proxy);
    }
}
