<?php

//$serviceAccount = ServiceAccount::fromJsonFile(ROOT.DS.'library'.DS.'utils'.DS.'config'.DS.'admin.json');
//$apiKey = 'AIzaSyCdztNG0nuYkiApLcpL-nnKLzV7W_s2G6Q';
//
//$firebase = (new Factory)
//->withServiceAccountAndApiKey($serviceAccount, $apiKey)
//->withDatabaseUri(FIREBASE_URL)
//->create();
//
//$database = $firebase->getDatabase();

//    $newPost = $database
//    ->getReference('roles')
//    ->push([
//    'name' => 'tracker'
//    ]);
//
//    $newPost->getValue(); // Fetches the data from the realtime database
//
//    $newPost->getKey(); // => -KVr5eu8gcTv7_AHb-3-
//    $newPost->getUri(); // => https://my-project.firebaseio.com/blog/posts/-KVr5eu8gcTv7_AHb-3-
//
//    $newPost->getChild('name')->set('Change tracker');
//    $newPost->getValue(); // Fetches the data from the realtime database
//
//    $newPost->remove();

//$auth = $firebase->getAuth();
//
//$user = $auth->createUserWithEmailAndPassword('user@domain.tld', 'pass$1234');
//$userConnection = $firebase->asUser($user);

// grab the first argument
//if (empty($argv[1])) {
//    die("usage: php listBuckets [project_id]\n");
//}
//
//$projectId = $argv[1];

putenv('GOOGLE_APPLICATION_CREDENTIALS=' . ROOT . DS . 'library' . DS . 'utils' . DS . 'config' . DS . 'admin.json');
$client = new Google_Client();
$client->useApplicationDefaultCredentials();
$client->addScope(Google_Service_Storage::CLOUD_PLATFORM);

$storage = new Google_Service_Storage($client);

// create the datastore service class
$datastore = new Google_Service_Datastore($client);

// build the query
$request = new Google_Service_Datastore_RunQueryRequest();
$query = new Google_Service_Datastore_Query();
//   - set the order
$order = new Google_Service_Datastore_PropertyOrder();
$order->setDirection('descending');
$property = new Google_Service_Datastore_PropertyReference();
$property->setName('title');
$order->setProperty($property);
$query->setOrder([$order]);
//   - set the kinds
$kind = new Google_Service_Datastore_KindExpression();
$kind->setName('Book');
$query->setKind($kind);
//   - set the limit
$query->setLimit(10);

// add the query to the request and make the request
$request->setQuery($query);
$response = $datastore->projects->runQuery('santour-e9abc', $request);
print_r($response);

/**
 * Google Cloud Storage API request to retrieve the list of buckets in your project.
 */
$buckets = $storage->buckets->listBuckets("santour-e9abc");

foreach ($buckets['items'] as $bucket) {
    printf("%s\n", $bucket->getName());
}