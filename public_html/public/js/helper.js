//Lấy hình ảnh bằng Ckfinder 2
function BrowseServer()
{
    var finder = new CKFinder();
    //finder.basePath = '../images/images/slider';
    finder.selectActionFunction = SetFileField;
    finder.popup();
}
function SetFileField( fileUrl )
{
    //get link image
    var fileName = fileUrl.split('/');
    document.getElementById('xFilePath').value = fileName[fileName.length-1];
    //show image
    var blah = document.getElementById('blah');
    blah.src = fileUrl;
}