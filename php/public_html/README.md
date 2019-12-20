## OBS  
### Important msg form Jørn:  
> This is the CMS that I have been working on from 2014, it was the first thing called Sandsized (Sandsized-CMS),  
> which I would like to remain.  
> You(as in Sandsized Developer Team) are welcome to contribute and use this.  
> However the generel design of the structure has not yet been figured out, why the code, and the whole setup  
> it not perfect yet (Who knows if it ever will be xD).  
> Anyway I will try to migrate all the code from Github (The enemy) to the IMADA git server, this also includes the plugins that I have been writing.  
> As said there is still not a good interface between this Main-Core and the plugins.  
> There is also a problem with Database logins in clear text, why ALL repositories regarding this HAS TO BE PRIVATE!!!  
> Hopefully I will figure out something smarter which does not have the password in a file on the git-sever.  
> The domains sandsized.dk and sandsized.com will use this CMS, and I will make a reposetory for the specific website, since this is the Main-Core.  



## CMS sandsized

Replace following when "install" on new page: 

REPLACE_ME_PATH -> if install in root folder delete this  
ReplaceDB -> this is the prefix for databasenames  
  
Make new Repo and add this an upstream:   
  
git remote add upstream git@git.imada.sdu.dk:Sandsized/Sandsized-CMS.git  

When the upsteam is set, get the core by typing:  
git pull upstream master  
  
And upload it to the currrent repo  
git push origin master  
  
When you have to update the core use these comands:   
git fetch upstream  
git merge upstream/master  
git push origin master  
  
Global Information 

