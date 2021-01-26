var albumBucketName = "heartbreaka-bachelors";
var bucketRegion = "us-east-2";
var IdentityPoolId = "us-east-2:e908c5ab-acfc-4b5f-b7c6-ecc0e07f923d";

AWS.config.update({
  region: bucketRegion,
  credentials: new AWS.CognitoIdentityCredentials({
    IdentityPoolId: IdentityPoolId
  })
});


var s3 = new AWS.S3({
  apiVersion: "2006-03-01",
  params: { Bucket: albumBucketName }
});
