package loginpage;

//Imports
import javafx.event.ActionEvent;
import java.io.IOException;
import java.util.logging.Level;
import java.util.logging.Logger;
import javafx.application.Application;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.scene.control.Label;
import javafx.scene.control.PasswordField;
import javafx.stage.Stage;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import javafx.scene.control.TextField;
import javafx.scene.image.Image;

/**
 * @author Iain Woodburn
 */
public class LoginPage extends Application {
    
    //For building the windows
    private static Parent root;
    private static Scene scene;
    //Must be public to open new windows in different controllers
    public static Stage primaryStage; 
    private FXMLLoader loader;
    
    //FXML fx:id
    @FXML private TextField username_field;
    @FXML private PasswordField password_field1;
    @FXML private Label errorLogin;
    
    //For mySQL
    Connection myConn;
    Statement myStatement;
    ResultSet myRs;
    private static final String URL = "jdbc:mysql://localhost:3306/new_schema?autoReconnect=true&useSSL=false";
    private static final String USERNAME = "root";
    private static final String PASSWORD = "J@c0bsl0om";
    
    /**
     * Starts the program, and opens the first window
     * @param primaryStage - first window 
     */
    @Override
    @SuppressWarnings("static-access")
    public void start(Stage primaryStage) {
        
        try {
            this.primaryStage = primaryStage;
            loader = new FXMLLoader(getClass().getResource("Login.fxml"));
            loader.load();
            
            root = FXMLLoader.load(getClass().getResource("Login.fxml"));
            scene = new Scene(root);
            primaryStage.setTitle("Login");
            primaryStage.setScene(scene);
            primaryStage.getIcons().add(new Image(getClass().getResourceAsStream("images/jacobsloomicon.png")));
            primaryStage.show();
        } catch (IOException ex) {
            Logger.getLogger(getClass().getName()).log(Level.SEVERE, null, ex);
        }

    }
    
    /**
     * @param args the command line arguments
     */
    public static void main(String[] args) {
        launch(args);
    }
    
    /**
     * Gets a connection to the database
     */
    private void getConnectionToDB(){
        
        try {
            myConn = DriverManager.getConnection(URL, USERNAME , PASSWORD);
            //Creates a statement
            myStatement = myConn.createStatement();
        } catch (SQLException ex) {
            Logger.getLogger(LoginPage.class.getName()).log(Level.SEVERE, null, ex);
        }
        
    } //end getConnectionToDB
    
    /**
     * Handles the event of logging into the application
     * @param evt - When the login button is clicked
     */
    @SuppressWarnings({"CallToPrintStackTrace", "UseSpecificCatch"})
    @FXML
    public void loginButton(ActionEvent evt){
        
        try{
            //Gets the string from the username box and password box 
            String username = username_field.getText();
            String password = password_field1.getText();
            
            //Password found in the database
            String dbPassword = "";
            
            //Formats the username so that it can be used in the mySQL statement
            username = "'".concat(username.concat("'"));
            
            //Opens connection with the database
            getConnectionToDB();
            
            //Gets specific username from database
            myRs = myStatement.executeQuery("SELECT * FROM employees WHERE emp_username=" + username);
            
            while(myRs.next()){
                //Gets the password stored inside the database
                dbPassword = myRs.getString("emp_password"); //hashed password
            }
            
            //Verifies hashed password with the one provided, using BCrypt
            if(BCrypt.checkpw(password , dbPassword)){
                //If password is correct, and username is found, then sets the window to the card reader
                root = FXMLLoader.load(getClass().getResource("CardReader.fxml"));
                scene = new Scene(root);
                primaryStage.setTitle("Card Reader");
                primaryStage.setScene(scene);
                primaryStage.show();
            } else {
                errorLogin.setText("Username or password was incorrect");
            }
            
        }catch (Exception e){
            errorLogin.setText("Username or password was incorrect");
            e.printStackTrace();
        }
        
    } //end loginButton

} //end class
