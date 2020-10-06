<?php

header('Access-Control-Allow-Origin: *');
date_default_timezone_set("UTC"+1);

/**
 * Generates a shared access signature for Microsoft Azure storage
 * cf. https://docs.microsoft.com/en-us/rest/api/storageservices/fileservices/constructing-an-account-sas 
 *
 * @param (accountName) The name of the Microsoft Azure storage account
 * @param (storageKey) The access key of the Microsoft Azure storage account
 * @param (signedPermissions) Required. Specifies the signed permissions for the account SAS
 * @param (signedService) Required. Specifies the signed services accessible with the account SAS
 * @param (signedResourceType) Required. Specifies the signed resource types that are accessible with the account SAS.
 * @param (signedStart) Optional. The time at which the SAS becomes valid, in an ISO 8601 format. 
 * @param (signedExpiry) Required. The time at which the shared access signature becomes invalid, in an ISO 8601 format.
 * @param (signedIP) Optional. Specifies an IP address or a range of IP addresses from which to accept requests.
 * @param (signedProtocol) Optional. Specifies the protocol permitted for a request made with the account SAS.
 * @param (signedVersion) Required. Specifies the signed storage service version to use to authenticate requests made with this account SAS
 * @return The shared access signature encoded as base64
 */
function generateSharedAccessSignature($accountName, 
    $storageKey, 
    $signedPermissions, 
    $canonicalResource, 
    $signedResourceType, 
    $signedStart, 
    $signedExpiry, 
    $signedIP, 
    $signedProtocol, 
    $signedVersion){

    if(empty($accountName)){
        trigger_error("The account name is required.");
        return;
    }

    if(empty($storageKey)){
        trigger_error("The account key is required.");
        return;
    }

    if(empty($signedPermissions)){
        trigger_error("The permissions are required.");
        return;
    }

    if(empty($signedResourceType)){
        trigger_error("The resource types are required.");
        return;
    }

    if(empty($signedExpiry)){
        trigger_error("The expiration time is required.");
        return;
    }

    if(empty($signedVersion)){
        trigger_error("The service version is required.");
        return;
    }


    // generate the string to sign
    $_toSign = urldecode($signedPermissions) . "\n" . //sp
               urldecode($signedStart) . "\n" . //ss
               urldecode($signedExpiry) . "\n" . // se
               urldecode($canonicalResource) . "\n" . //cr
                         "\n" .  //si
               urldecode($signedIP) . "\n" . //sip
               urldecode($signedProtocol) . "\n" . //spr
               urldecode($signedVersion) . "\n". //sv
               urldecode($signedResourceType) . "\n" . //sr
               "\n". //sst
               "\n". //rscc
               "\n". //rscd
               "\n". //rsce
               "\n"; //rscl //rsct
            
    //    echo "STRING TO SIGN = " . $_toSign;
    //    echo "<br /><br />";

    // sign the string using hmac sha256 and get a base64 encoded version_compare
    $_signature = base64_encode(hash_hmac("sha256", utf8_encode($_toSign), base64_decode($storageKey), true));

    return $_signature;
}

function getBlobUrlWithSharedAccessSignature($blobUri,
    $signedVersion,
    $signedService,
    $signedResourceType,
    $signedPermissions,
    $canonicalResource,
    $signedStart,
    $signedExpiry,
    $signedIP,
    $signedProtocol,
    $signature) {

    
    /* Create the signed query part */
    $_urlParts = array();
    $_urlParts[] = "sv=" . $signedVersion;
    $_urlParts[] = "sr=" . $signedResourceType;
    $_urlParts[] = "sp=" . $signedPermissions;
    $_urlParts[] = "st=" . $signedStart;
    $_urlParts[] = "se=" . $signedExpiry;
    $_urlParts[] = "spr=" . $signedProtocol;
    $_urlParts[] = "sig=" . urlencode($signature);

    $_blobUrlWithSAS = $blobUri . "?" . implode("&", $_urlParts);

    return $_blobUrlWithSAS;
}

$_storageKey = "vgY9k1uoHB66ayULRs7QfCTSYHWB2zC3csjdCCo77K1vp8iR2asl/CeRmr/dTMU0Exg7hCuATuqpL9fiGbCpzA==";
$_accountName = "0067team14smileapp";
$_signedPermissions = "r";
$_signedResourceType = "b";
$_signedStart = date('Y-m-d') . "T" . date('H:i:s') . "Z";
$_signedExpiry = date("Y-m-d", time() + 86400) . "T" . date('H:i:s') . "Z";
$_signedIP = "";
$_signedProtocol = "https";
$_signedVersion = "2019-02-02";
$container = $_GET['container']; // e.g. "readingimages";
$imageName = $_GET['imageName']; // e.g. "5e8f322fb61460.93499875.jpeg";
$canonicalResource = "/blob/0067team14smileapp/" . $container . "/" . $imageName;

// generate the signature
$_signature = generateSharedAccessSignature($_accountName, 
    $_storageKey, 
    $_signedPermissions,
    $canonicalResource,
    $_signedResourceType, 
    $_signedStart, 
    $_signedExpiry, 
    $_signedIP, 
    $_signedProtocol, 
    $_signedVersion);

//echo "SIGNATURE = " . $_signature;
//echo "<br /><br />";

$_blobUrl = getBlobUrlWithSharedAccessSignature("https://0067team14smileapp.blob.core.windows.net/" . $container . "/" . $imageName,
    $_signedVersion,
    $_signedService,
    $_signedResourceType,
    $_signedPermissions,
    $canonicalResource,
    $_signedStart,
    $_signedExpiry,
    $_signedIP,
    $_signedProtocol,
    $_signature);

header('Content-Type: application/json');
echo json_encode($_blobUrl);
//echo "<br /><br />";

?>