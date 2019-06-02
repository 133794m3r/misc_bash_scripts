grep -lIUr "^M" . | xargs sed -i 's/^M//'
