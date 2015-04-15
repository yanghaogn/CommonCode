package org.apache.hadoop.io;

import java.io.DataInput;
import java.io.DataOutput;
import java.io.IOException;

/**
 * Created by yang on 2015/4/1.
 */
public class TextPair implements WritableComparable<TextPair> {
  private Text left;
  private Text right;

  public TextPair(Text left, Text right) {
    this.left = left;
    this.right = right;
  }

  public TextPair(String left, String right) {
    this.left = new Text(left);
    this.right = new Text(right);
  }

  public void setLeft(Text text) {
    this.left.set(text);
  }

  public void setRight(Text text) {
    this.right.set(text);
  }

  public Text getLeft() {
    return left;
  }

  public Text getRight() {
    return right;
  }

  @Override
  public boolean equals(Object o) {
    if (o instanceof TextPair) {
      TextPair other = (TextPair) o;
      return left.equals(other.left) && right.equals(other.right);
    }
    return false;
  }

  @Override
  public int compareTo(TextPair o) {
    int cmp = left.compareTo(o.left);
    cmp = (cmp == 0 ? right.compareTo(o.right) : cmp);
    return cmp;
  }

  @Override
  public void write(DataOutput dataOutput) throws IOException {
    left.write(dataOutput);
    right.write(dataOutput);
  }

  @Override
  public void readFields(DataInput dataInput) throws IOException {
    left.readFields(dataInput);
    right.readFields(dataInput);
  }

  @Override
  public int hashCode() {
    return left.hashCode() * 163 + right.hashCode();
  }

  @Override
  public String toString() {
    return left + "\t" + right;
  }

  static {
    WritableComparator.define(TextPair.class, new TextPairComparator());
  }
  public static class TextPairComparator extends WritableComparator {
    private static final Text.Comparator TEXT_COMPARATOR = new Text.Comparator();

    public TextPairComparator() {
      super(TextPair.class);
    }

    @Override
    public int compare(byte[] b1, int s1, int l1, byte[] b2, int s2, int l2) {
      try {
        int leftLen1 = WritableUtils.decodeVIntSize(b1[s1]) + readVInt(b1, s1);
        int leftLen2 = WritableUtils.decodeVIntSize(b2[s2]) + readVInt(b2, s2);
        int cmp = TEXT_COMPARATOR.compare(b1, s1, leftLen1, b2, s2, leftLen2);
        if (cmp != 0) {
          return cmp;
        }
        return TEXT_COMPARATOR.compare(b1, s1 + leftLen1, l1 - leftLen1,
            b2, s2 + leftLen2, l2 - leftLen2);
      } catch (IOException e) {
        throw new IllegalArgumentException(e);
      }
    }
    @Override
    public int compare(WritableComparable a, WritableComparable b) {
      if (a instanceof TextPair && b instanceof TextPair) {
        int cmp = ((TextPair) a).left.compareTo(((TextPair) b).left);
        if(cmp != 0){
          return cmp;
        }
        return ((TextPair) a).right.compareTo(((TextPair) b).right);
      }
      return super.compare(a, b);
    }
  }
}
