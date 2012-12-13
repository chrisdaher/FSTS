@echo off
echo %1
echo %2
cd %2
hg pull -r %1
hg update