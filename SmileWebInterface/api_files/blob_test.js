<?php
require_once 'vendor/autoload.php';

use WindowsAzure\Common\ServicesBuilder;
use MicrosoftAzure\Storage\Blob\Models\CreateContainerOptions;
use MicrosoftAzure\Storage\Blob\Models\PublicAccessType;
use MicrosoftAzure\Storage\Common\ServiceException;

function BlobUrl()
{
    var account = new CloudStorageAccount(new StorageCredentials('0067team14smileapp', 'vgY9k1uoHB66ayULRs7QfCTSYHWB2zC3csjdCCo77K1vp8iR2asl/CeRmr/dTMU0Exg7hCuATuqpL9fiGbCpzA=='), true);
    var cloudBlobClient = account.CreateCloudBlobClient();
    var container = cloudBlobClient.GetContainerReference("readingimages");
    var blob = container.GetBlockBlobReference("5e8f322fb61380.15528265.jpg");
   // blob.UploadFromFile("File Path ....");//Upload file....

    var blobUrl = blob.Uri.AbsoluteUri;

    return blobUrl;
}

echo BlobUrl

?>