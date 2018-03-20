

git init
git add README.md
git commit -m "first commit"
git remote add origin https://github.com/lmaroncelli/volontari.git
git push -u origin master
…or push an existing repository from the command line
￼
git remote add origin https://github.com/lmaroncelli/volontari.git
git push -u origin master
…or import code from another repository
You can initialize this repository with code from a Subversion, Mercurial, or TFS project.


https://help.github.com/articles/fetching-a-remote/



git push -u origin master
Username for 'https://github.com': lmaroncelli
Password for 'https://lmaroncelli@github.com': 
Counting objects: 4, done.
Delta compression using up to 4 threads.
Compressing objects: 100% (3/3), done.
Writing objects: 100% (4/4), 689 bytes | 689.00 KiB/s, done.
Total 4 (delta 1), reused 0 (delta 0)
remote: Resolving deltas: 100% (1/1), completed with 1 local object.
To https://github.com/lmaroncelli/volontari.git
   e723211..591afa5  master -> master
Branch master set up to track remote branch master from origin.




To grab a complete copy of another user's repository, use git clone like this:

$ git clone https://github.com/lmaroncelli/volontari.git
# Clones a repository to your computer

git pull remotename branchname
# Grabs online updates and merges them with your local work