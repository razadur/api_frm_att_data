# api_frm_att_data
api for attendance data


+-------------------+
|	address of api	|
+-------------------+

http://...host.../frmAtt.php?token=''&reg=''&limit=''




+-------------------+
|	use of address	|
+-------------------+

all values are mandatory 

token:
	tELYtALK
	
reg:
	RC - REGISTERED CARD
	UC - UNREGISTERED CARD
	
limit:
	limit is how much chunk of data will be processed in once.
	value must be more then zero.
	
	
+-------------------+
|	For Scheduler	|
+-------------------+

D:\xampp\php\php.exe -f D:\xampp\htdocs\frm_att_data\frmAtt.php




git clone URL_of_github_or_bitbucket
git status
git add -A				-A for all, single file name is also allowed
git commit -m ""		commit with massage
git push
