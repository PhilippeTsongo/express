<?php  



class HttpRequests
{
    public static function HttRequest($url, $method = "POST", $data = array(), $requesttoken = null, $contenttype = "urlform")
    {
        $ch = curl_init();
        switch ($contenttype):
            case "urlform":
                $data = http_build_query($data);
                $contenttype = 'application/x-www-form-urlencoded';
                break;
            case "json":
                $data = json_encode($data);
                $contenttype = 'application/json';
                break;
            case "xml":
                $xml = new SimpleXMLElement('COMMAND');
                array_walk_recursive($data, array($xml, 'commad'));
                print $xml->asXML();
                $contenttype = 'application/xml';
                break;

            default:
                break;
        endswitch;

        curl_setopt($ch, CURLOPT_URL, $url);
        switch ($method):
            case "POST":
                curl_setopt($ch, CURLOPT_POST, true);
                if ($data)
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                break;
            case "PUT":
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
                if ($data)
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                break;
            default:
                break;
        endswitch;

        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: ' . $requesttoken, 'Content-Type:' . $contenttype));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }

}


?>