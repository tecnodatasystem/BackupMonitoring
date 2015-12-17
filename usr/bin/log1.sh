rm -rf /var/www/openmediavault/logs/*.txt
df -h > /var/www/openmediavault/logs/output.txt;
cd /
mountA=$(find -name 'BACKUP' -type d -not -path '/media/*/BACKUP/*');
mountB=$(find -name 'COPIE' -type d -not -path '/media/*/COPIE/*');
if [ -n "${mountA}" ]; then
        mount=$(dirname $mountA);
        basename=$(basename $mountA)
elif [ -n "${mountB}" ]; then
        mount=$(dirname $mountB);
        basename=$(basename $mountB)
fi
for d in `find $mount"/"$basename/* -maxdepth 0 -type d -not -path *$basename'/'`;
        do d=${d:1};
        FOLD=$(basename $d);
        stat $d > /var/www/openmediavault/logs/$FOLD.txt;
        cd $d;
        du -h --max-depth=0 >> /var/www/openmediavault/logs/$FOLD.txt;
        cd ../;
done;
