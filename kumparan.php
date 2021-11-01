<?php

function kumparan_news($search_word) {

//read json file
//read json file for PILPRES 2019
//$json = fetch_http_file_contents($url_page);
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://graphql-v4.kumparan.com/query",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 300,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => '[{"operationName":"FindCurrentUser","variables":{},"query":"query FindCurrentUser {\n  FindCurrentUser {\n    ...User\n    __typename\n  }\n}\n\nfragment User on User {\n  __typename\n  id\n  name\n  username\n  aboutMe\n  email\n  phone\n  emailVerified\n  phoneVerified\n  profilePictureMedia {\n    ...Media\n    __typename\n  }\n  coverPictureMedia {\n    ...Media\n    __typename\n  }\n  gender\n  userStatus: status\n  birthDate\n  isRecommended\n  createdAt\n  updatedAt\n  deletedAt\n  aboutMe\n  isVerified\n  websiteURL\n  isSelf\n}\n\nfragment Media on Media {\n  id\n  title\n  description\n  publicID\n  externalURL\n  awsS3Key\n  height\n  width\n  locationName\n  locationLat\n  locationLon\n  mediaType\n  mediaSourceID\n  photographer\n  eventDate\n  __typename\n}\n"},{"operationName":"SearchAllStoriesV2","variables":{"query":"'.$search_word.'","cursor":"1","size":10,"cursorType":"PAGE"},"query":"query SearchAllStoriesV2($query: String!, $cursor: String, $cursorType: CursorType!, $size: Int!) {\n  SearchAllStoriesV2(query: $query, cursor: $cursor, cursorType: $cursorType, size: $size) {\n    ...StoryCursor\n    __typename\n  }\n}\n\nfragment StoryCursor on StoryCursor {\n  edges {\n    ...Story\n    __typename\n  }\n  cursorInfo {\n    ...CursorInfo\n    __typename\n  }\n  __typename\n}\n\nfragment Story on Story {\n  __typename\n  id\n  authorID\n  title\n  createdAt\n  updatedAt\n  deletedAt\n  publishedAt\n  source\n  isAgeRestrictedContent\n  slug\n  status\n  leadText\n  publisherID\n  publishedRevisionID\n  draftRevisionID\n  metaDescription\n  metaKeyword\n  customTrackerImpressionURL\n  customTrackerScript\n  sponsorID\n  locationName\n  locationLat\n  locationLon\n  internalCreatorID\n  lastUpdatedBy\n  isCleanView\n  isStickyStory\n  isShowOnWeb\n  isShowOnApp\n  isDisableComment\n  isDisableLike\n  isDisableShare\n  isSnackable\n  sponsor {\n    ...Sponsor\n    __typename\n  }\n  author {\n    ...User\n    __typename\n  }\n  publisher {\n    ...Publisher\n    __typename\n  }\n  editors {\n    ...User\n    __typename\n  }\n  reporters {\n    ...User\n    __typename\n  }\n  headline {\n    ...Headline\n    __typename\n  }\n  storyAddOns {\n    ...StoryAddOn\n    __typename\n  }\n  contentPublish {\n    ...Document\n    __typename\n  }\n  contentDraft {\n    ...Document\n    __typename\n  }\n  leadMedia {\n    ...Media\n    __typename\n  }\n  topics {\n    ...Topic\n    __typename\n  }\n  channel {\n    ...Channel\n    __typename\n  }\n}\n\nfragment Channel on Channel {\n  id\n  name\n  slug\n  meta_title\n  meta_description\n  meta_keywords\n  __typename\n}\n\nfragment Media on Media {\n  id\n  title\n  description\n  publicID\n  externalURL\n  awsS3Key\n  height\n  width\n  locationName\n  locationLat\n  locationLon\n  mediaType\n  mediaSourceID\n  photographer\n  eventDate\n  __typename\n}\n\nfragment Topic on Topic {\n  __typename\n  id\n  name\n  slug\n  description\n  isActive\n  isPrivate\n  isSpecial\n  isShowTopicCover\n  coverMedia {\n    ...Media\n    __typename\n  }\n}\n\nfragment Sponsor on Sponsor {\n  id\n  name\n  description\n  url\n  media {\n    ...Media\n    __typename\n  }\n  __typename\n}\n\nfragment User on User {\n  __typename\n  id\n  name\n  username\n  aboutMe\n  email\n  phone\n  emailVerified\n  phoneVerified\n  profilePictureMedia {\n    ...Media\n    __typename\n  }\n  coverPictureMedia {\n    ...Media\n    __typename\n  }\n  gender\n  userStatus: status\n  birthDate\n  isRecommended\n  createdAt\n  updatedAt\n  deletedAt\n  aboutMe\n  isVerified\n  websiteURL\n  isSelf\n}\n\nfragment Publisher on Publisher {\n  __typename\n  id\n  name\n  slug\n  description\n  website\n  isVerified\n  isActive\n  coverMedia {\n    ...Media\n    __typename\n  }\n  avatarMedia {\n    ...Media\n    __typename\n  }\n  publisherGroupID\n}\n\nfragment Headline on Headline {\n  storyID\n  desktopMedia {\n    ...Media\n    __typename\n  }\n  mobileMedia {\n    ...Media\n    __typename\n  }\n  startTime\n  endTime\n  __typename\n}\n\nfragment StoryAddOn on StoryAddOn {\n  object {\n    __typename\n    ... on Polling {\n      ...Polling\n      __typename\n    }\n    ... on Gallery {\n      ...Gallery\n      __typename\n    }\n  }\n  addOnType\n  __typename\n}\n\nfragment Polling on Polling {\n  __typename\n  id\n  name\n  description\n  mediaID\n  startsAt\n  endsAt\n  questions {\n    ...Question\n    __typename\n  }\n}\n\nfragment Question on Question {\n  id\n  pollingID\n  detail\n  position\n  choices {\n    ...Choice\n    __typename\n  }\n  __typename\n}\n\nfragment Choice on Choice {\n  id\n  questionID\n  detail\n  mediaID\n  position\n  stats\n  __typename\n}\n\nfragment Gallery on Gallery {\n  __typename\n  id\n  name\n  description\n  galleryMedias {\n    ...GalleryMedia\n    __typename\n  }\n}\n\nfragment GalleryMedia on GalleryMedia {\n  mediaID\n  caption\n  description\n  media {\n    ...Media\n    __typename\n  }\n  __typename\n}\n\nfragment Document on Document {\n  id\n  document\n  type\n  __typename\n}\n\nfragment CursorInfo on CursorInfo {\n  size\n  count\n  countPage\n  hasMore\n  cursor\n  cursorType\n  nextCursor\n  __typename\n}\n"}]',
  CURLOPT_HTTPHEADER => array(
    "Accept: */*",
    "Accept-Encoding: gzip, deflate",
    "Cache-Control: no-cache",
    "Connection: keep-alive",
    //"Content-Length: 5169",
    "Content-Type: application/x-www-form-urlencoded",
    //"Cookie: web_tracker_userId=; web_tracker_cookieId=ab486d7e-26c3-4dc9-be5d-dc141d876e5d; web_tracker_userAliasId=cac35fde-1d99-43d5-9c50-6fab4ad190ce",
    "Host: graphql-v4.kumparan.com",
    "Origin: https://kumparan.com",
    //"Postman-Token: c0f675b6-5373-4a4b-b37f-177829f83305,396340db-9ef3-48b3-a946-980082197a46",
    "Referer: https://kumparan.com/search/".$search_word."/",
    "User-Agent: PostmanRuntime/7.15.2",
    "cache-control: no-cache"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {

  $kumparan_saved_file = [
    'date'     => [],
    'link'     => [],
    'title'    => [],
    'body'    => []
  ];

  $json_data = json_decode($response, true);

  for($i=0; $i<=4; $i++) {

    $date_temp = $json_data[1]['data']['SearchAllStoriesV2']['edges'][$i]['createdAt'];
    $date = explode('T',$date_temp)[0];
    $kumparan_saved_file['date'][$i] = $date;

    //putting together the link address
    $category = $json_data[1]['data']['SearchAllStoriesV2']['edges'][$i]['author']['username'];
    $link_slug = $json_data[1]['data']['SearchAllStoriesV2']['edges'][$i]['slug'];
    $kumparan_saved_file['link'][$i] = 'http://kumparan.com/'.$category.'/'.$link_slug;

    $kumparan_saved_file['title'][$i] = $json_data[1]['data']['SearchAllStoriesV2']['edges'][$i]['title'];
  }//END OF FOR LOOP

  for($j=0; $j<=4; $j++) {
    $url_page = $kumparan_saved_file['link'][$j];

    $html = file_get_contents($url_page);
    $html_encoded = htmlentities($html);

    /*** a new dom object ***/
    $dom = new domDocument;
    libxml_use_internal_errors(true);
    /*** load the html into the object ***/
    $dom->loadHTML($html);
    $dom_xpath = new DOMXpath($dom);

    $paras = $dom_xpath->query("//div[@class='StoryRenderer__EditorWrapper-azlsyx-0 hoGrrr']/div");


    $fulltext = '';
    foreach ($paras as $para) {

      $fulltext = $fulltext.'<br>'.$para->nodeValue;
    }

    $kumparan_saved_file['body'][$j] = $fulltext;


  }



}// END OF ELSE

//StoryRenderer__EditorWrapper-azlsyx-0 hoGrrr

return $kumparan_saved_file;
} //end of function bracket

?>
