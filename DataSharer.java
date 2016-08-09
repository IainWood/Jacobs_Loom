package loginpage;

/**
 * This will hold all of the information that should be accessible
 * by all windows. An alternative to making lots of global variables.
 * There is probably a better way of doing this, but for right now,
 * this works.
 * @author Iain Woodburn
 */
public class DataSharer {
    
    private static String username;
    private static String track1;
    private static String track2;
    private static String track3;
    
    public static void setUsername(String user){
        username = user;
    }
    
    public static void setTrack1(String track){
        track1 = track;
    }
    
    public static void setTrack2(String track){
        track2 = track;
    }
    
    public static void setTrack3(String track){
        track3 = track;
    }
    
    public static String getUsername(){
        return username;
    }
    
    public static String getTrack1(){
        return track1;
    }
    
    public static String getTrack2(){
        return track2;
    }
    
    public static String getTrack3(){
        return track3;
    }
    
} //end class
