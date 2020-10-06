<?php
// The file blobConfig.php has been adapted from https://github.com/uglide/azure-content/blob/master/articles/storage/storage-php-how-to-use-blobs.md
// Specifically the function uploadBlob has been infuenced by https://stackoverflow.com/questions/15829936/azure-set-blob-content-type-using-php
// Specifically the function deleteBlob has been influenced by https://docs.microsoft.com/en-us/azure/storage/blobs/storage-quickstart-blobs-php?tabs=windows

require_once 'vendor/autoload.php';

use WindowsAzure\Common\ServicesBuilder;
use MicrosoftAzure\Storage\Blob\Models\CreateContainerOptions;
use MicrosoftAzure\Storage\Blob\Models\PublicAccessType;
use MicrosoftAzure\Storage\Common\ServiceException;

function uploadBlob($containerDestination, $currentImageLocation, $blobName, $fileType){
    $imageLocationString = "".$currentImageLocation;
    //Connection String for the BlobStorage Account
    $blobConnectionString = 'DefaultEndpointsProtocol=https;AccountName=0067team14smileapp;AccountKey=vgY9k1uoHB66ayULRs7QfCTSYHWB2zC3csjdCCo77K1vp8iR2asl/CeRmr/dTMU0Exg7hCuATuqpL9fiGbCpzA==;BlobEndpoint=https://0067team14smileapp.blob.core.windows.net';

    $blobRestProxy = ServicesBuilder::getInstance()->createBlobService($blobConnectionString);
    $content = fopen($imageLocationString, "r");
    try	{
        //Upload blob
        $blobRestProxy->createBlockBlob($containerDestination, $blobName, $content);
        //echo "Success";
    }
    catch(ServiceException $e){
        // Handle exception based on error codes and messages.
        // Error codes and messages are here:
        // http://msdn.microsoft.com/library/azure/dd179439.aspx
        $code = $e->getCode();
        $error_message = $e->getMessage();
        $errorMessage = $code.": ".$error_message;
    }
}

function deleteBlob($containerName, $blobFileName){
    //Connection String for the BlobStorage Account
    $blobConnectionString = 'DefaultEndpointsProtocol=https;AccountName=0067team14smileapp;AccountKey=vgY9k1uoHB66ayULRs7QfCTSYHWB2zC3csjdCCo77K1vp8iR2asl/CeRmr/dTMU0Exg7hCuATuqpL9fiGbCpzA==;BlobEndpoint=https://0067team14smileapp.blob.core.windows.net';
    $blobRestProxy = ServicesBuilder::getInstance()->createBlobService($blobConnectionString);
    
    try	{
        //Upload blob
        $blobRestProxy->deleteBlob($containerName, $blobFileName);
        //echo "Success";
    }
    catch(ServiceException $e){
        // Handle exception based on error codes and messages.
        // Error codes and messages are here:
        // http://msdn.microsoft.com/library/azure/dd179439.aspx
        $code = $e->getCode();
        $error_message = $e->getMessage();
        $errorMessage = $code.": ".$error_message;
    }
}
?>