#!/bin/bash

# args
MSG=${1-'deploy from git'}
BRANCH=${2-'trunk'}

# paths
SRC_DIR=$(git rev-parse --show-toplevel)
BUILD_DIR=$SRC_DIR/build
DIR_NAME=$(basename $SRC_DIR)
DEST_DIR=~/svn/wp-plugins/woo-category-slider-by-pluginever/$BRANCH



# make sure the destination dir exists
svn mkdir $DEST_DIR 2> /dev/null
svn add $DEST_DIR 2> /dev/null

# delete everything except .svn dirs
for file in $(find $DEST_DIR/* -not -path "*.svn*")
do
    rm $file 2>/dev/null
    #echo $file
done

# copy everything over from git
rsync -r --exclude='*.git*' --exclude="node_modules" --exclude="build" --exclude="vendor/danielstjules/stringy/tests" $BUILD_DIR/* $DEST_DIR
# git checkout-index -a -f --prefix=$DEST_DIR/

# delete readme.md from git checkout




cd $DEST_DIR

# check .svnignore
for file in $(cat "$SRC_DIR/.svnignore" 2>/dev/null)
do
    rm -rf $file
done

# Transform the readme
#README=$(find $DEST_DIR -iname 'README.m*')
#sed -i '' -e 's/^# \(.*\)$/=== \1 ===/' -e 's/ #* ===$/ ===/' -e 's/^## \(.*\)$/== \1 ==/' -e 's/ #* ==$/ ==/' -e 's/^### \(.*\)$/= \1 =/' -e 's/ #* =$/ =/' $README

#mv $README $DEST_DIR/readme.txt

# svn addremove
svn stat | grep '^\?' | awk '{print $2}' | xargs svn add > /dev/null 2>&1
svn stat | grep '^\!' | awk '{print $2}' | xargs svn rm  > /dev/null 2>&1

svn stat
svn ci -m "$MSG"
