clc;
tic
A=load('a');
B=load('b');
toc
[rowA,colA]=size(A);
[rowB,colB]=size(B);
if colA~=rowB
    disp('矩阵A的列数不等于矩阵B的行数');
else
    C=A*B
    toc
    %输出到文件c.txt
    fid = fopen('C:\Users\Administrator\Desktop\matlab\c','wt');
    for k=1:length(C(:,1))
        p=num2str(C(k,:));
        fprintf(fid,'%c',p);
        fprintf(fid,'\n');
    end
    
    fclose(fid);
end
toc