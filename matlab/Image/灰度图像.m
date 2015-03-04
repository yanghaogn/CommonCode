clc;
source=imread('qq.png');
[row,col,hei]=size(source);
target=source;
for r=1:row
    for c=1:col
           a=source(r,c,1)+source(r,c,2)+source(r,c,3);     
           target(r,c,1)=a/1.5;
           target(r,c,2)=a/2;
           target(r,c,3)=a/3;
    end
end
imwrite(target,'tmp.jpg');
