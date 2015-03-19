package com.yang.commoncode.core;

import java.util.Collections;
import java.util.LinkedList;
import java.util.List;

/**
 * Created by yang on 15-3-18.
 */
public class Demo {
  public static void main(String [] args){
    List<Double> list =new LinkedList<Double>();
    for(int i = 0 ;i < 10; i++){
      list.add(Math.random()*1000);
    }
    Collections.sort(list);
    for(double element: list){
      System.out.println(element);
    }
  }
}
