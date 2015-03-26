package com.yang.commoncode.core; /**
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

import org.apache.hadoop.conf.Configuration;
import org.apache.hadoop.fs.FSDataInputStream;
import org.apache.hadoop.fs.FSDataOutputStream;
import org.apache.hadoop.fs.FileSystem;
import org.apache.hadoop.fs.Path;

import java.io.IOException;

public class HadoopDFSFileReadWrite {

  static void usage() {
    System.out.println("Usage : HadoopDFSFileReadWrite <inputfile> <output file>");
    System.exit(1);
  }

  static void printAndExit(String str) {
    System.err.println(str);
    System.exit(1);
  }

  public static void main(String[] argv) throws IOException {
    Configuration conf = new Configuration();
    FileSystem fs = FileSystem.get(conf);

    if (argv.length != 2)
      usage();

    // Hadoop DFS deals with Path
    Path inFile = new Path(argv[0]);
    Path outFile = new Path(argv[1]);

    // Check if input/output are valid
    if (!fs.exists(inFile))
      printAndExit("Input file not found");
    if (!fs.isFile(inFile))
      printAndExit("Input should be a file");
    if (fs.exists(outFile))
      printAndExit("Output already exists");

    // Read from and write to new file
    FSDataInputStream in = fs.open(inFile);
    FSDataOutputStream out = fs.create(outFile);
    byte buffer[] = new byte[256];
    try {
      int bytesRead = 0;
      while ((bytesRead = in.read(buffer)) > 0) {
        out.write(buffer, 0, bytesRead);
      }
    } catch (IOException e) {
      System.out.println("Error while copying file");
    } finally {
      in.close();
      out.close();
    }
  }
}
