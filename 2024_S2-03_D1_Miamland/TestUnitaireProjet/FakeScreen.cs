using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace IUTGame.Fake
{
    /// <summary>
    /// Simulate a screen, in order to test the game without a real screen.
    /// </summary>
    public class FakeScreen : IScreen
    {
        private KeyEvent keyDown;
        private KeyEvent keyUp;
        private MouseWheelEvent mouseWheel;
        private MouseButtonEvent mouseDown;
        private MouseButtonEvent mouseUp;
        private MouseMoveEvent mouseMove;
        private const int WIDTH = 800;
        private const int HEIGHT = 600;
        private string lastMessage;
        private const int SPRITE_HEIGHT = 48; // Example height for a sprite
        private const int SPRITE_WIDTH = 64; // Example width for a sprite
        private static int id = 1;

        /// <summary>
        /// Containst last message stored by a simulated action (used for testing)
        /// </summary>
        public string LastMessage => lastMessage;
        public KeyEvent KeyDown { get => keyDown; set => keyDown = value; }
        public KeyEvent KeyUp { get => keyUp; set => keyUp=value; }
        public MouseWheelEvent MouseWheel { get => mouseWheel; set => mouseWheel=value; }
        public MouseButtonEvent MouseDown { get => mouseDown; set => mouseDown=value; }
        public MouseButtonEvent MouseUp { get => mouseUp; set => mouseUp=value; }
        public MouseMoveEvent MouseMove { get => mouseMove; set => mouseMove=value; }

        public double Width => WIDTH;

        public double Height => HEIGHT;

        public void DrawSprite(int spriteID, double x, double y, double angle = 0, double scaleX = 1, double scaleY = 1, int zindex = 0)
        {
            lastMessage = $"Draw sprite {spriteID} at {x},{y} with angle of {angle} and scale {scaleX},{scaleY}, at {zindex} z-index";
        }

        public void Focus()
        {
            lastMessage = "focused";
        }

        public double GetSpriteHeight(int spriteID)
        {
            return SPRITE_HEIGHT;
        }

        public double GetSpriteWidth(int spriteID)
        {
            return SPRITE_WIDTH;
        }

        public void InitSpritesStore(string spritesFolderName)
        {
            lastMessage = $"Sprites store initialized with folder: {spritesFolderName}";
        }

        public int LoadSprite(string spriteName)
        {
            id++;
            lastMessage = $"Sprite {spriteName} loaded, given id {id}";
            return id;
        }

        public void RemoveSprite(int spriteID)
        {
            lastMessage = $"Sprite {spriteID} removed";
        }
    }
}
