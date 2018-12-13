<?php
/**
 * @Author: Prawee Wongsa <prawee.w@integra8t.com>
 * @Date: 2018-12-13 04:59
 */
require __DIR__.'/vendor/autoload.php';

if (empty($_SERVER['APPLICATION_ID'])) {
    (new \Dotenv\Dotenv(__DIR__))->load();
}

use Google\Cloud\Storage\StorageClient;

if (!empty($_FILES['uploaded_files'])) {
    $projectId = getenv('APP_PROJECT_ID');
    $bucketName = getenv('APP_BUCKET_NAME');
    $storage = new StorageClient([
        'keyFilePath' => __DIR__.'/'.getenv('GOOGLE_APPLICATION_CREDENTIALS'),
        'projectId' => $projectId
    ]);

    $file = fopen($_FILES['uploaded_files']['tmp_name'], 'r');
    $filename = $_FILES['uploaded_files']['name'];
    $filename = 'bn'.date('Ymd_his').'.'.array_pop(explode('.', $_FILES['uploaded_files']['name']));

    $bucket = $storage->bucket($bucketName);
    $object = $bucket->upload($file, [
        'resumable' => true,
        'name' => 'blog/banner/'.$filename
    ]);
    printf('Uploaded %s to gs://%s/%s' . PHP_EOL, basename($source), $bucketName, $objectName);

}
?>
<form action="index.php" method="post" enctype="multipart/form-data">
    <input type="file" name="uploaded_files" size="40">
    <input type="submit" value="Send">
</form>

