#!/bin/bash
backup_git="stash_git.tar"
stash() {
echo "Stashing....."
tar -czf $backup_git $git_list
rm -rf $git_list
}
apply() {
echo "Applying....."
tar -xf $backup_git && rm $backup_git
}
if [ "$1" = "apply" ]
then
if [ -f $backup_git ]
then
apply
else
echo "Nothing to apply"
fi
else
git_list=`find vendor/ -name ".git*"`
if [ "$git_list" ]
then
stash
else
echo "Nothing to stash."
exit 0
fi
fi
exit 1;