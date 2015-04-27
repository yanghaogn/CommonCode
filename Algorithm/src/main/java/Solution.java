import junit.framework.Assert;
import org.junit.Test;

import java.io.*;
import java.util.*;

public class Solution {
 public static void main(String []args){
   try {
     FileInputStream inputStream = new FileInputStream ("D://read.txt");
     BufferedReader bufferedReader = new BufferedReader(new InputStreamReader(inputStream));
     String content;
     for(int i = 0; (content = bufferedReader.readLine()) != null ;i++){
       if(i % 5 == 0){
         StringTokenizer itr = new StringTokenizer(content);
         while (itr.hasMoreTokens()){
           System.out.print(itr.nextToken() + "\t");
         }
         System.out.println();
       }
     }
     bufferedReader.close();
   } catch (FileNotFoundException e) {
     e.printStackTrace();
   } catch (IOException e) {
     e.printStackTrace();
   }
 }
}
