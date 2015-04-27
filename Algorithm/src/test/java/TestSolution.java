import junit.framework.Assert;
import org.junit.Test;

/**
 * Created by yang on 2015/4/15.
 */
public class TestSolution {
  @Test
  public void testGetShortestSubString() {
    Solution solution = new Solution();
    System.out.println(Runtime.getRuntime().totalMemory());
  }

  private ThreadLocal<Integer> tl = new ThreadLocal<Integer>() {
    @Override
    protected Integer initialValue() {
      return 0;
    }
  };
}
