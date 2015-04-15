package org.apache.hadoop.io;

import org.apache.hadoop.util.StringUtils;
import org.junit.Assert;
import org.junit.Test;

import java.io.IOException;

/**
 * Created by yang on 2015/4/1.
 */
public class TestUtilsWritable {
  @Test
  public void testSerialize() throws IOException {
    byte []temp = new UtilsWritable().serialize(new IntWritable(18));
    Assert.assertEquals(4,temp.length);
    Assert.assertEquals(StringUtils.byteToHexString(temp), "00000012");
  }
  @Test
  public void testDeserialize() throws IOException {
    IntWritable one = new IntWritable(1);
    byte[]temp = UtilsWritable.serialize(one);
    IntWritable result = new IntWritable();
    UtilsWritable.deSerialize(result, temp);
    Assert.assertEquals(one.get(), result.get());
  }
  @Test
  public void testCompare() throws IOException {
    RawComparator<IntWritable> comparator = WritableComparator.get(IntWritable.class);
    IntWritable a = new IntWritable(14);
    IntWritable b = new IntWritable(11);
    Assert.assertTrue(comparator.compare(a, b) > 0);
    byte[] a1 =UtilsWritable. serialize(a);
    byte[] b1 = UtilsWritable.serialize(b);
    Assert.assertTrue(comparator.compare(a1, 0, a1.length, b1, 0, b1.length) > 0);
  }
}
