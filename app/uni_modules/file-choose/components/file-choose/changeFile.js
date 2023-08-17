// chooseFile.js文件内容
function chooseFile(callback, acceptType) {
	//acceptType为你要查的文件类型"image/*"，"audio/*"，"video/*;image/*"  
	// intent.setType("image/*");
	//intent.setType("audio/*"); 
	//选择音频
	//intent.setType("video/*;image/*"); 
	//选择视频 （mp4 3gp 是android支持的视频格式）
	var CODE_REQUEST = 1000;
	var main = plus.android.runtimeMainActivity();
	if (plus.os.name == 'Android') {
		var Intent = plus.android.importClass('android.content.Intent');
		var intent = new Intent(Intent.ACTION_GET_CONTENT);
		intent.addCategory(Intent.CATEGORY_OPENABLE);
		if (acceptType) {
			intent.setType(acceptType);
		} else {
			intent.setType("*/*");
		}
		main.onActivityResult = function(requestCode, resultCode, data) {
			if (requestCode == CODE_REQUEST) {
				var uri = data.getData();
				plus.android.importClass(uri);
				var Build = plus.android.importClass('android.os.Build');
				var isKitKat = Build.VERSION.SDK_INT >= Build.VERSION_CODES.KITKAT;

				var DocumentsContract = plus.android.importClass('android.provider.DocumentsContract');
				if (isKitKat && DocumentsContract.isDocumentUri(main, uri)) {
					if ("com.android.externalstorage.documents" == uri.getAuthority()) {
						var docId = DocumentsContract.getDocumentId(uri);
						var split = docId.split(":");
						var type = split[0];

						if ("primary" == type) {
							var Environment = plus.android.importClass('android.os.Environment');
							callback(Environment.getExternalStorageDirectory() + "/" + split[1]);
						} else {
							var System = plus.android.importClass('java.lang.System');
							var sdPath = System.getenv("SECONDARY_STORAGE");
							if (sdPath) {
								callback(sdPath + "/" + split[1]);
							}
						}
					}
					else if ("com.android.providers.downloads.documents" == uri.getAuthority()) {
						var id = DocumentsContract.getDocumentId(uri);
						var ContentUris = plus.android.importClass('android.content.ContentUris');
						var contentUri = ContentUris.withAppendedId(
							Uri.parse("content://downloads/public_downloads"), id);
						callback(getDataColumn(main, contentUri, null, null));
					}
					else if ("com.android.providers.media.documents" == uri.getAuthority()) {
						var docId = DocumentsContract.getDocumentId(uri);
						var split = docId.split(":");
						var type = split[0];

						var MediaStore = plus.android.importClass('android.provider.MediaStore');
						if ("image" == type) {
							contentUri = MediaStore.Images.Media.EXTERNAL_CONTENT_URI;
						} else if ("video" == type) {
							contentUri = MediaStore.Video.Media.EXTERNAL_CONTENT_URI;
						} else if ("audio" == type) {
							contentUri = MediaStore.Audio.Media.EXTERNAL_CONTENT_URI;
						}

						var selection = "_id=?";
						var selectionArgs = new Array();
						selectionArgs[0] = split[1];

						callback(getDataColumn(main, contentUri, selection, selectionArgs));
					}
				}
				else if ("content" == uri.getScheme()) {
					callback(getDataColumn(main, uri, null, null));
				}
				// File
				else if ("file" == uri.getScheme()) {
					callback(uri.getPath());
				}
			}
		}
		main.startActivityForResult(intent, CODE_REQUEST);
	}
}

function getDataColumn(main, uri, selection, selectionArgs) {
	console.log('main:' + main);
	console.log('uri:' + uri);
	console.log('selection:' + selection);
	console.log('selectionArgs:' + selectionArgs);
	plus.android.importClass(main.getContentResolver());
	let cursor = main.getContentResolver().query(uri, ['_data'], selection, selectionArgs,
		null);
	plus.android.importClass(cursor);
	if (cursor != null && cursor.moveToFirst()) {
		var column_index = cursor.getColumnIndexOrThrow('_data');
		var result = cursor.getString(column_index)
		cursor.close();
		return result;
	}
	return null;
}

export default chooseFile
